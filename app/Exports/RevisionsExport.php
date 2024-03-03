<?php

namespace App\Exports;

use App\Models\Score;
use App\Models\Schedule;
use App\Models\CLO;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class RevisionsExport implements FromView, WithTitle
{

    private $period_id, $prodi_name;

    public function __construct($period_id, $prodi_name)
    {
        $this->period_id = $period_id;
        $this->prodi_name = $prodi_name;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $period_id = $this->period_id;
        $prodi_name = $this->prodi_name;
        $data['schedules'] = Schedule::with('revisions')
            ->whereHas('sidang', function ($query) use ($period_id,$prodi_name) {
                $query->where('period_id', $period_id);
                $query->whereHas('mahasiswa', function ($subQuery) use ($prodi_name){
                    $subQuery->where('study_program',$prodi_name);
                });
            })
            ->get();
        return view('exports.revision_each_lecturer', $data);
    }

    public function title(): string
    {
        return $this->prodi_name;
    }
}
