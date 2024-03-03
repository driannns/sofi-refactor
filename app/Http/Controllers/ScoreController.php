<?php

namespace App\Http\Controllers;

use App\Exports\ScoreMultiplesExport;
use App\Http\Requests\CreateScoreRequest;
use App\Http\Requests\UpdateScoreRequest;
use App\Models\Score;
use App\Models\Schedule;
use App\Models\CLO;
use App\Models\Lecturer;
use App\Models\ScorePortion;
use App\Models\StudyProgram;
use App\Models\Team;
use App\Models\Sidang;
use Auth;
use Illuminate\Http\Request;
use Flash;
use Response;
use DB;
use Excel;

class ScoreController extends AppBaseController
{
    /**
     * Display a listing of the Score.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Score $scores */
        $scores = Score::all();

        return view('scores.index')
            ->with('scores', $scores);
    }

    /**
     * Show the form for creating a new Score.
     *
     * @return Response
     */
    public function create($id)
    {
        // editan baru
        $penguji = schedule::with('detailpenguji1')->where('id', '=', $id)->first();
        $penguji1 = Lecturer::with('user')->where('id', '=', $penguji->penguji1)->first();
        $penguji2 = Lecturer::with('user')->where('id', '=', $penguji->penguji2)->first();
        $pembimbing = schedule::with('sidang')->where('id', '=', $id)->first();
        $p = sidang::with('pembimbing1')->where('id', '=', $pembimbing->sidang->pembimbing1_id)->first();
        $pembimbing1 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing1_id)->first();
        $pembimbing2 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing2_id)->first();

        $npembimbing1 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $pembimbing->sidang->pembimbing1_id)
            ->count();
        $npembimbing2 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $pembimbing->sidang->pembimbing2_id)
            ->count();
        $npenguji1 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $penguji->penguji1)
            ->count();
        $npenguji2 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $penguji->penguji2)
            ->count();
// akhir
        $schedule = Schedule::find($id);
        $studyProgram = $schedule->sidang->mahasiswa->study_program;
        $studyProgramId = StudyProgram::where('name', $studyProgram)->first()->id;

        if($studyProgram == null)
        {
            Flash::error('Form Nilai tidak bisa dimunculkan!! Data Prodi Mahasiswa tidak tersedia, Harap hubungi admin LAAK untuk update data');
            return redirect()->back();
        }

        $clos = CLO::where('period_id', $schedule->sidang->period_id)->where('study_program_id', $studyProgramId)
            ->whereHas('components', function ($query) use ($id) {
                if (Auth::user()->isPembimbing1($id) || Auth::user()->isPembimbing2($id))
                    $query->where('pembimbing', '<>', 0);
                else if (Auth::user()->isPenguji1($id) || Auth::user()->isPenguji2($id))
                    $query->where('penguji', '<>', 0);
            })
            ->get();
        if (count($clos) == 0) {
            $clos = CLO::where('period_id', $schedule->sidang->period_id)
                ->whereHas('components', function ($query) use ($id) {
                    if (Auth::user()->isPembimbing1($id) || Auth::user()->isPembimbing2($id))
                        $query->where('pembimbing', '<>', 0);
                    else if (Auth::user()->isPenguji1($id) || Auth::user()->isPenguji2($id))
                        $query->where('penguji', '<>', 0);
                })
                ->get();
        }

        if (empty($schedule)) {
            Flash::error('Sidang tidak ditemukan');
            return redirect()->back();
        }
        if ($schedule->status != 'sedang dilaksanakan') {
            Flash::error('Tidak dapat menilai sekarang');
            return redirect()->back();
        }

        $scores = null;
        return view('scores.create', compact('penguji1', 'penguji2', 'pembimbing1', 'pembimbing2'
            , 'npenguji1', 'npenguji2', 'npembimbing1', 'npembimbing2', 'scores', 'schedule', 'clos'));
    }

    /**
     * Store a newly created Score in storage.
     *
     * @param CreateScoreRequest $request
     *
     * @return Response
     */
    public function store(CreateScoreRequest $request)
    {
        for ($i = 0; $i < count($request->value); $i++) {
            Score::insert([
                'value' => $request->value[$i],
                'percentage' => $request->percentage[$i],
                'component_id' => $request->component_id[$i],
                'jadwal_id' => $request->jadwal_id,
                'user_id' => Auth::user()->lecturer->id,
            ]);
        }

        $scores = Score::where('jadwal_id', $request->jadwal_id)
            ->where('user_id', Auth::user()->lecturer->id)
            ->get();
        $currentScore = $this->getCurrentScore($scores);
        if ($currentScore < 50) {
            Flash::warning('Berhasil Menilai. Nilai yang anda berikan berpotensi menyebabkan sidang ulang pada mahasiswa! pilih tombol ubah nilai untuk mengubah nilai!');
        } else {
            Flash::success('Berhasil Menilai. untuk melihat score yang baru saja anda berikan, pilih tombol ubah nilai');
        }

        if ($request->role == 'pembimbing') {
            return redirect('schedule/pembimbing');
        } else {
            return redirect('schedule/penguji');
        }

    }

    /**
     * Display the specified Score.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Score $score */
        $score = Score::find($id);

        if (empty($score)) {
            Flash::error('Score Tidak ada');

            return redirect(route('scores.index'));
        }

        return view('scores.show')->with('score', $score);
    }

    /**
     * Show the form for editing the specified Score.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        //edit baru
        $penguji = schedule::with('detailpenguji1')->where('id', '=', $id)->first();
        $penguji1 = Lecturer::with('user')->where('id', '=', $penguji->penguji1)->first();
        $penguji2 = Lecturer::with('user')->where('id', '=', $penguji->penguji2)->first();
        $pembimbing = schedule::with('sidang')->where('id', '=', $id)->first();
        $p = sidang::with('pembimbing1')->where('id', '=', $pembimbing->sidang->pembimbing1_id)->first();
        $pembimbing1 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing1_id)->first();
        $pembimbing2 = Lecturer::with('user')->where('id', '=', $pembimbing->sidang->pembimbing2_id)->first();
// return $pembimbing1;
        $npembimbing1 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $pembimbing->sidang->pembimbing1_id)
            ->count();
        $npembimbing2 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $pembimbing->sidang->pembimbing2_id)
            ->count();
        $npenguji1 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $penguji->penguji1)
            ->count();
        $npenguji2 = DB::table('schedules')
            ->join('scores', 'scores.jadwal_id', '=', 'schedules.id')
            ->where('schedules.id', '=', $id)
            ->where('scores.user_id', '=', $penguji->penguji2)
            ->count();
        // return $nilai;
        // return $pembimbing1;
        //akhir
        $nilai = Schedule::with('scores')->where('id', '=', $id)->first();
        $lecturer_id = $request->query('lid');
        //code penguji / pembimbing
        $code = $request->query('code');
        $schedule = Schedule::find($id);
        $studyProgram = $schedule->sidang->mahasiswa->study_program;
        $studyProgramId = StudyProgram::where('name', $studyProgram)->first()->id;

        if (Auth::user()->isSuperadmin() && $code != null) {
            $clos = CLO::where('period_id', $schedule->sidang->period_id)->where('study_program_id', $studyProgramId)
                ->whereHas('components', function ($query) use ($id, $code) {
                    if ($code == 'pembimbing')
                        $query->where('pembimbing', '<>', 0);
                    else if ($code == 'penguji')
                        $query->where('penguji', '<>', 0);
                })
                ->get();
            if (count($clos)==0) {
                $clos = CLO::where('period_id', $schedule->sidang->period_id)
                    ->whereHas('components', function ($query) use ($id, $code) {
                        if ($code == 'pembimbing')
                            $query->where('pembimbing', '<>', 0);
                        else if ($code == 'penguji')
                            $query->where('penguji', '<>', 0);
                    })
                    ->get();
            }
            $scores = Score::where('jadwal_id', $id)
                ->where('user_id', $lecturer_id)
                ->get();
        } else {

            $clos = CLO::where('period_id', $schedule->sidang->period_id)->where('study_program_id', $studyProgramId)
                ->whereHas('components', function ($query) use ($id) {
                    if (Auth::user()->isPembimbing1($id) || Auth::user()->isPembimbing2($id))
                        $query->where('pembimbing', '<>', 0);
                    else if (Auth::user()->isPenguji1($id) || Auth::user()->isPenguji2($id))
                        $query->where('penguji', '<>', 0);
                })
                ->get();
            if (count($clos)==0) {
                $clos = CLO::where('period_id', $schedule->sidang->period_id)
                    ->whereHas('components', function ($query) use ($id) {
                        if (Auth::user()->isPembimbing1($id) || Auth::user()->isPembimbing2($id))
                            $query->where('pembimbing', '<>', 0);
                        else if (Auth::user()->isPenguji1($id) || Auth::user()->isPenguji2($id))
                            $query->where('penguji', '<>', 0);
                    })
                    ->get();
            }
            $scores = Score::where('jadwal_id', $id)
                ->where('user_id', Auth::user()->lecturer->id)
                ->get();
        }
        if (count($scores) == 0) {
            Flash::error('Nilai belum di inputkan, anda tidak bisa mengubah nilai');
            return redirect()->back();
        } else {
            $currentScore = $this->getCurrentScore($scores);
//editan baru
            if ($currentScore <= 40) {
                $grade = '(E)';
            } else if ($currentScore > 40 && $currentScore <= 50) {
                $grade = '(D)';
            } else if ($currentScore > 50 && $currentScore <= 60) {
                $grade = '(C)';
            } else if ($currentScore > 60 && $currentScore <= 65) {
                $grade = '(BC)';
            } else if ($currentScore > 65 && $currentScore <= 70) {
                $grade = '(B)';
            } else if ($currentScore > 70 && $currentScore <= 80) {
                $grade = '(AB)';
            } else if ($currentScore > 80) {
                $grade = '(A)';
            } else {
                $grade = '(A)';
            }
//            dd($clos[0]->components[0]->intervals[0]->ekuivalensi);
            return view('scores.edit', compact('penguji1', 'penguji2', 'pembimbing1', 'pembimbing2'
                , 'npenguji1', 'npenguji2', 'npembimbing1', 'npembimbing2', 'scores', 'schedule', 'clos', 'currentScore', 'grade', 'lecturer_id'));
            //akhir
        }
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

    /**
     * Update the specified Score in storage.
     *
     * @param int $id
     * @param UpdateScoreRequest $request
     *
     * @return Response
     */
    public function update($schedule_id, UpdateScoreRequest $request)
    {
        $lecturer_id = $request->query('lid');

        if (Auth::user()->isSuperadmin() && $lecturer_id) {
            for ($i = 0; $i < count($request->value); $i++) {
                Score::where('component_id', $request->component_id[$i])
                    ->where('jadwal_id', $request->jadwal_id)
                    ->where('user_id', $lecturer_id)
                    ->update([
                        'value' => $request->value[$i],
                    ]);
            }
            $scores = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', $lecturer_id)
                ->get();
        } else {
            for ($i = 0; $i < count($request->value); $i++) {
                Score::where('component_id', $request->component_id[$i])
                    ->where('jadwal_id', $request->jadwal_id)
                    ->where('user_id', Auth::user()->lecturer->id)
                    ->update([
                        'value' => $request->value[$i],
                    ]);
            }
            $scores = Score::where('jadwal_id', $schedule_id)
                ->where('user_id', Auth::user()->lecturer->id)
                ->get();
        }
        $currentScore = $this->getCurrentScore($scores);
        if ($currentScore < 50) {
            Flash::warning('Berhasil mengubah score. Nilai yang anda berikan berpotensi menyebabkan sidang ulang pada mahasiswa! pilih tombol ubah nilai untuk mengubah nilai!');
        } else {
            Flash::success('Berhasil mengubah score. untuk melihat score yang baru saja anda berikan, pilih tombol ubah nilai');
        }

        //update status flag change scores to false
        $schedule = schedule::find($schedule_id);
        $schedule->flag_change_scores = false;
        $schedule->update();

        if ($request->role == 'pembimbing') {
            return redirect('schedule/pembimbing');
        } else {
            return redirect('schedule/penguji');
        }
    }

    /**
     * Remove the specified Score from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Score $score */
        $score = Score::find($id);

        if (empty($score)) {
            Flash::error('Score Tidak ada');

            return redirect(route('scores.index'));
        }

        $score->delete();

        Flash::success('Score Berhasil Dihapus.');

        return redirect(route('scores.index'));
    }

    public function show_simpulan($schedule_id)
    {

        //get clo and score data
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
            $penilai[$i]['clos'] = CLO::where('period_id', $schedule->sidang->period_id)->where('study_program_id', $studyProgramId)
                ->whereHas('components', function ($query) use ($schedule_id, $lecturer) {
                    if ($lecturer->isPembimbing1($schedule_id) || $lecturer->isPembimbing2($schedule_id))
                        $query->where('pembimbing', '<>', 0);
                    else if ($lecturer->isPenguji1($schedule_id) || $lecturer->isPenguji2($schedule_id))
                        $query->where('penguji', '<>', 0);
                })
                ->get();
            if (count($penilai[$i]['clos'])==0) {
                $penilai[$i]['clos'] = CLO::where('period_id', $schedule->sidang->period_id)
                    ->whereHas('components', function ($query) use ($schedule_id, $lecturer) {
                        if ($lecturer->isPembimbing1($schedule_id) || $lecturer->isPembimbing2($schedule_id))
                            $query->where('pembimbing', '<>', 0);
                        else if ($lecturer->isPenguji1($schedule_id) || $lecturer->isPenguji2($schedule_id))
                            $query->where('penguji', '<>', 0);
                    })
                    ->get();
            }
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

        $indeks = "";
        if ($nilaiTotal > 80) {
            $indeks = "A";
        } else if ($nilaiTotal > 70) {
            $indeks = "AB";
        } else if ($nilaiTotal > 65) {
            $indeks = "B";
        } else if ($nilaiTotal > 60) {
            $indeks = "BC";
        } else if ($nilaiTotal > 50) {
            $indeks = "C";
        } else if ($nilaiTotal > 40) {
            $indeks = "D";
        } else {
            $indeks = "E";
        }

        return view('scores.simpulan', compact(
            'nilaiPenguji1',
            'nilaiPenguji2',
            'nilaiPembimbing1',
            'nilaiPembimbing2',
            'nilaiTotal',
            'indeks',
            'schedule',
            'penilai',
            'porsi_nilai'
        ));

    }

    public function process_simpulan(Request $request, $schedule_id)
    {
        $putusan = $request->putusan;
        $schedule = Schedule::find($schedule_id);

        DB::beginTransaction();

        if ($putusan == "tidak lulus") {
            $schedule->sidang->update([
                'status' => 'tidak lulus',
            ]);
            $schedule->sidang->mahasiswa->update([
                'team_id' => 0,
            ]);
            $team = Team::where('name', $schedule->sidang->mahasiswa->nim . " Sidang Individu")->delete();
            StatusLogController::addStatusLog($schedule->sidang->id, "-", "pengajuan", "tidak lulus");
        } elseif ($putusan == "lulus") {
            $schedule->sidang->update([
                'status' => 'lulus',
                'updated_at' => now()
            ]);
            StatusLogController::addStatusLog($schedule->sidang->id, "-", "lulus", "lulus");
            $this->sendNotification(
                $schedule->sidang->mahasiswa->nim,
                "Lulus",
                "Selamat Anda telah dinyatakan lulus",
                "sidangs/create"
            );
        } elseif ($putusan == "0") {
            Flash::error('Keputusan belum anda pilih');
            return redirect()->back();
        } else {
            if ($schedule->sidang->status == 'tidak lulus') {
                $schedule->sidang->update([
                    'status' => 'sudah dijadwalkan',
                ]);
            }
        }

        if ($putusan == 'lulus' || $putusan == 'tidak lulus') {
            $durasi_revisi = null;
        } else {
            $durasi_revisi = $request->durasi_revisi;
        }

        $schedule->update([
            'keputusan' => $putusan,
            'status' => 'telah dilaksanakan',
            'durasi_revisi' => $durasi_revisi,
        ]);

        //revision status auto disetujui jika tidak lulus
        if($putusan == 'tidak lulus'){
            foreach($schedule->revisions as $revision){
                $revision->update([
                    'status' => 'disetujui'
                ]);
            }
        }


        DB::commit();

        Flash::success('Berhasil menyimpan keputusan, Status sidang sudah selesai.');
        return redirect(route('schedule.penguji'));
    }

    public function export($period_id)
    {
        return Excel::download(new ScoreMultiplesExport($period_id), 'scores.xlsx');
    }

}
