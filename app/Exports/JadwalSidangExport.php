<?php

namespace App\Exports;

use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class JadwalSidangExport implements FromView
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
            $schedules = Schedule::whereBetween('date', [$this->tanggal_awal, $this->tanggal_akhir])->get();
        else
            $schedules = Schedule::whereHas('sidang', function ($query) {
                $query->where('period_id', $this->period_id);
            })->get();

        $data = $this->getExportData($schedules);
        return view('exports.jadwal')->with([
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
            foreach ($getExportDatas->data as $getExportData) {
                if ($getExportData->studentid == $schedule->sidang->mahasiswa_id) {
                    $data[$index] = $getExportData;
                    break;
                } else {
                    $data[$index] = null;
                }
            }
        }
        return $data;
    }
}
