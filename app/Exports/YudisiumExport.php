<?php

namespace App\Exports;

use App\Models\Schedule;
use App\Models\Lecturer;
use App\Models\CLO;
use App\Models\Score;
use App\Models\ScorePortion;
use App\Models\StudyProgram;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class YudisiumExport implements FromView
{
    private $tanggal_awal = null;
    private $tanggal_akhir = null;
    private $period_id = null;

    public function __construct($period_id = null, $tanggal_awal = null, $tanggal_akhir = null)
    {
        if ($period_id == null) {
            $this->tanggal_akhir = $tanggal_akhir;
            $this->tanggal_awal = $tanggal_awal;
        } else {
            $this->period_id = $period_id;
        }
    }

    public function view(): View
    {
        if ($this->period_id == null)
            $schedules = Schedule::whereBetween('date', [$this->tanggal_awal, $this->tanggal_akhir])
                ->where('keputusan', '!=', 'tidak lulus')
                ->get();
        else
            $schedules = Schedule::where('keputusan', '!=', 'tidak lulus')
                ->whereHas('sidang', function ($query) {
                    $query->where('period_id', $this->period_id);
                })->get();

        $data = $this->getExportData($schedules);
        return view('exports.yudisium')->with([
            'schedules' => $schedules,
            'extensions' => $data
        ]);
    }

    private function getExportData(Collection $schedules)
    {
        $data = null;
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('GET', config('app.api.getDataExport'));
        $getExportDatas = json_decode($response->getBody());
        foreach ($schedules as $index => $schedule) {
            $data[$index]['score'] = $this->getScheduleScore($schedule->id);
            $data[$index]['api'] = null;
            foreach ($getExportDatas->data as $getExportData) {
                if ($getExportData->studentid == $schedule->sidang->mahasiswa_id) {
                    $data[$index]['api'] = $getExportData;
                    break;
                }
            }
        }
        return $data;
    }

    private function getScheduleScore($schedule_id)
    {
        $schedule = Schedule::find($schedule_id);
        $studyProgram = $schedule->sidang->mahasiswa->study_program;
        $studyProgramId = StudyProgram::where('name', $studyProgram)->first()->id;
        $penguji1_id = $schedule->penguji1;
        $penguji2_id = $schedule->penguji2;
        $pembimbing1_id = $schedule->sidang->pembimbing1_id;
        $pembimbing2_id = $schedule->sidang->pembimbing2_id;

        $penilai_id = [$penguji1_id, $penguji2_id, $pembimbing1_id, $pembimbing2_id];
        $penilai = [];
        $penilai[0]['role'] = 'penguji';
        $penilai[1]['role'] = 'penguji';
        $penilai[2]['role'] = 'pembimbing';
        $penilai[3]['role'] = 'pembimbing';
        for ($i = 0; $i < count($penilai_id); $i++) {
            $penilai[$i]['lecturer'] = Lecturer::with('user')->find($penilai_id[$i]);
            $lecturer = Lecturer::find($penilai_id[$i])->user;
            $penilai[$i]['clos'] = CLO::where('period_id', $schedule->sidang->period_id)
                ->whereHas('components', function ($query) use ($schedule_id, $lecturer) {
                    if ($lecturer->isPembimbing1($schedule_id) || $lecturer->isPembimbing2($schedule_id))
                        $query->where('pembimbing', '<>', 0);
                    else if ($lecturer->isPenguji1($schedule_id) || $lecturer->isPenguji2($schedule_id))
                        $query->where('penguji', '<>', 0);
                })
                ->get();
            $penilai[$i]['scores'] = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', $penilai_id[$i])
                ->get();
            $penilai[$i]['currentScore'] = $this->getCurrentScore($penilai[$i]['scores']);
        }

        $nilaiPenguji1 = 0;
        $nilaiPenguji2 = 0;
        $nilaiPembimbing1 = 0;
        $nilaiPembimbing2 = 0;
        $totalPercentagePenguji1 = 0;
        $totalPercentagePenguji2 = 0;
        $totalPercentagePembimbing1 = 0;
        $totalPercentagePembimbing2 = 0;
        foreach ($schedule->scores as $score) {
            if ($score->isPenguji1()) {
                $nilaiPenguji1 = $nilaiPenguji1 + ($score->percentage * ($score->value));
                $totalPercentagePenguji1 = $totalPercentagePenguji1 + $score->percentage;
            } else if ($score->isPenguji2()) {
                $nilaiPenguji2 = $nilaiPenguji2 + ($score->percentage * ($score->value));
                $totalPercentagePenguji2 = $totalPercentagePenguji2 + $score->percentage;
            } else if ($score->isPembimbing1()) {
                $nilaiPembimbing1 = $nilaiPembimbing1 + ($score->percentage * ($score->value));
                $totalPercentagePembimbing1 = $totalPercentagePembimbing1 + $score->percentage;
            } else if ($score->isPembimbing2()) {
                $nilaiPembimbing2 = $nilaiPembimbing2 + ($score->percentage * ($score->value));
                $totalPercentagePembimbing2 = $totalPercentagePembimbing2 + $score->percentage;
            }
        }
        //when total percentage 0, avoid div by 0
        if ($totalPercentagePenguji1 != 0) {
            $nilaiPenguji1 = $nilaiPenguji1 / $totalPercentagePenguji1;
        } else {
            $nilaiPenguji1 = 0;
        }
        if ($totalPercentagePenguji2 != 0) {
            $nilaiPenguji2 = $nilaiPenguji2 / $totalPercentagePenguji2;
        } else {
            $nilaiPenguji2 = 0;
        }
        if ($totalPercentagePembimbing1 != 0) {
            $nilaiPembimbing1 = $nilaiPembimbing1 / $totalPercentagePembimbing1;
        } else {
            $nilaiPembimbing1 = 0;
        }
        if ($totalPercentagePembimbing2 != 0) {
            $nilaiPembimbing2 = $nilaiPembimbing2 / $totalPercentagePembimbing2;
        } else {
            $nilaiPembimbing2 = 0;
        }

        $porsi_nilai = ScorePortion::where('period_id', $schedule->sidang->period_id)->where('study_program_id', $studyProgramId)->first();

        if($porsi_nilai){
            $nilaiTotal = ($porsi_nilai->pembimbing * (($nilaiPembimbing1 + $nilaiPembimbing2) / 2) / 100) + ($porsi_nilai->penguji * (($nilaiPenguji1 + $nilaiPenguji2) / 2) / 100);
        }else{
            $nilaiTotal = (60 * (($nilaiPembimbing1 + $nilaiPembimbing2) / 2) / 100) + (40 * (($nilaiPenguji1 + $nilaiPenguji2) / 2) / 100);
        }

        $data['nilaiPenguji1'] = $nilaiPenguji1;
        $data['nilaiPenguji2'] = $nilaiPenguji2;
        $data['nilaiPembimbing1'] = $nilaiPembimbing1;
        $data['nilaiPembimbing2'] = $nilaiPembimbing2;
        $data['nilaiTotal'] = $nilaiTotal;

        return $data;
    }

    private function getCurrentScore($scores)
    {
        $nilai = 0;
        $totalPercentage = 0;
        foreach ($scores as $score) {
            $nilai = $nilai + ($score->percentage * ($score->value));
            $totalPercentage = $totalPercentage + $score->percentage;
        }
        if ($totalPercentage != 0) {
            $nilai = $nilai / $totalPercentage;
        } else {
            $nilai = 0;
        }

        return $nilai;
    }
}
