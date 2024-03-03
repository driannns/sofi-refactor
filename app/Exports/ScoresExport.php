<?php

namespace App\Exports;

use App\Models\Score;
use App\Models\Schedule;
use App\Models\CLO;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class ScoresExport implements FromView, WithTitle
{

    private $period_id, $prodi_id, $prodi_name;

    public function __construct($period_id, $prodi_id, $prodi_name)
    {
        $this->period_id = $period_id;
        $this->prodi_id = $prodi_id;
        $this->prodi_name = $prodi_name;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $data = $this->score_each_clos();
        return view('exports.scores_each_clos', $data);
        // $data = $this->score_each_evaluator();
        // return view('exports.scores_each_evaluator',$data);
    }

    public function title(): string
    {
        return $this->prodi_name;
    }

    private function score_each_evaluator()
    {
        $period_id = $this->period_id;
        $data['schedules'] = Schedule::with('scores')
            ->whereHas('sidang', function ($query) use ($period_id) {
                $query->where('period_id', $period_id);
            })
            ->where('keputusan', 'lulus')
            ->get();
        $data['clos'] = CLO::where('period_id', $period_id)->get();
        $data['clo_penguji'] = CLO::where('period_id', $period_id)
            ->whereHas('components', function ($query) {
                $query->where('penguji', 1);
            })
            ->get();
        $data['clo_pembimbing'] = CLO::where('period_id', $period_id)
            ->whereHas('components', function ($query) {
                $query->where('pembimbing', 1);
            })
            ->get();

        foreach ($data['schedules'] as $schedule) {
            //pembimbing
            foreach ($data['clo_pembimbing'] as $clo_pembimbing) {
                $scores = Score::whereHas('jadwal.sidang', function ($query) use ($schedule) {
                    $query->where('mahasiswa_id', $schedule->sidang->mahasiswa_id);
                })
                    ->where('component_id', $clo_pembimbing->components[0]->id)
                    ->get();

                $score_pembimbing = 0;
                foreach ($scores as $score) {
                    if ($score->user_id != $schedule->penguji1 and $score->user_id != $schedule->penguji2) {
                        $score_pembimbing = $score_pembimbing + ($score->value / 2);
                    }
                }

                $data['scores'][$schedule->sidang->mahasiswa_id]['pembimbing'][$clo_pembimbing->code] = $score_pembimbing;
            }

            //penguji
            foreach ($data['clo_penguji'] as $clo_penguji) {
                $scores = Score::whereHas('jadwal.sidang', function ($query) use ($schedule) {
                    $query->where('mahasiswa_id', $schedule->sidang->mahasiswa_id);
                })
                    ->where('component_id', $clo_penguji->components[0]->id)
                    ->get();

                $score_penguji = 0;
                foreach ($scores as $score) {
                    if ($score->user_id == $schedule->penguji1 or $score->user_id == $schedule->penguji2) {
                        $score_penguji = $score_penguji + ($score->value / 2);
                    }
                }

                $data['scores'][$schedule->sidang->mahasiswa_id]['penguji'][$clo_penguji->code] = $score_penguji;
            }

        }

        return $data;
    }

    private function score_each_clos()
    {
        $period_id = $this->period_id;
        $prodi_id = $this->prodi_id;
        $prodi_name = $this->prodi_name;
        $data['schedules'] = Schedule::with('scores')
            ->whereHas('sidang', function ($query) use ($period_id,$prodi_name) {
                $query->where('period_id', $period_id);
                $query->whereHas('mahasiswa', function ($subQuery) use ($prodi_name){
                    $subQuery->where('study_program',$prodi_name);
                });
            })
            ->get();
        $data['clos'] = CLO::where('period_id', $period_id)->where('study_program_id', $prodi_id)->get();
        if (count($data['clos']) == 0)
            $data['clos'] = CLO::where('period_id', $period_id)->get();
        foreach ($data['clos'] as $clo) {
            foreach ($data['schedules'] as $index => $schedule) {
                $score_clo = 0;
                $score_pembimbing = 0;
                $score_penguji = 0;
                //jika clo tersebut memiliki presentase sama dan diassign ke penguji dan pembimbing
                if ($clo->components[0]->penguji == 1 and $clo->components[0]->pembimbing == 1) {
                    $scores = $schedule->scores->where('component_id', $clo->components[0]->id);
                    foreach ($scores as $score) {
                        if ($score->isPenguji1() or $score->isPenguji2()) {
                            $score_penguji = $score_penguji + ($score->value / 2);
                        } else {
                            $score_pembimbing = $score_pembimbing + ($score->value / 2);
                        }
                    }
                    $score_clo = ($score_pembimbing * 0.6) + ($score_penguji * 0.4);
                } else {
                    //jika component memiliki presentase beda yang diassign ke penguji dan pembimbing
                    if ($data['clos']->where('code', $clo->components[0]->code)->count() > 1) {
                        foreach ($schedule->scores as $score) {
                            if ($score->component->code == $clo->components[0]->code) {
                                if ($score->isPenguji1() or $score->isPenguji2()) {
                                    $score_penguji = $score_penguji + ($score->value / 2);
                                } else {
                                    $score_pembimbing = $score_pembimbing + ($score->value / 2);
                                }
                            }
                        }
                        $score_clo = ($score_pembimbing * 0.6) + ($score_penguji * 0.4);
                        //jika component hanya diassign ke penguji atau pembimbing saja
                    } else {
                        $scores = $schedule->scores->where('component_id', $clo->components[0]->id);
                        foreach ($scores as $score) {
                            if ($score->isPenguji1() or $score->isPenguji2()) {
                                $score_penguji = $score_penguji + ($score->value / 2);
                            } else {
                                $score_pembimbing = $score_pembimbing + ($score->value / 2);
                            }
                        }
                        $score_clo = ($score_pembimbing + $score_penguji);
                    }
                }
                $data['score_clos'][$index][$clo->components[0]->id] = $score_clo;
            }
        }
        return $data;
    }
}
