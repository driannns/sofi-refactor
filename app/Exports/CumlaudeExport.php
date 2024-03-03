<?php

namespace App\Exports;

use App\Models\Sidang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class CumlaudeExport implements FromView
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
            $sidangs = Sidang::whereBetween('created_at', [$this->tanggal_awal, $this->tanggal_akhir])
            ->where('status', 'lulus')
            ->get();
        else
            $sidangs = Sidang::where('period_id', $this->period_id)
            ->where('status', 'lulus')
            ->get();

        $data = $this->getExportData($sidangs);
        return view('exports.cumlaude')->with([
            'sidangs' => $sidangs,
            'extensions' => $data
        ]);
    }

    private function getExportData(Collection $sidangs)
    {
        $data = null;
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $response = $client->request('GET', config('app.api.getDataExport'));
        $getExportDatas = json_decode($response->getBody());
        foreach ($sidangs as $index => $sidang) {
            $data[$index] = null;
            foreach ($getExportDatas->data as $getExportData) {
                if ($getExportData->studentid == $sidang->mahasiswa_id) {
                    $data[$index] = $getExportData;
                    break;
                }
            }
        }
        return $data;
    }
}
