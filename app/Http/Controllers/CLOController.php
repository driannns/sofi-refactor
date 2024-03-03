<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCLORequest;
use App\Http\Requests\UpdateCLORequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CLO;
use App\Models\Period;
use App\Models\Interval;
use App\Models\Component;
use App\Models\StudyProgram;
use DB;
use Illuminate\Http\Request;
use Flash;
use Response;

class CLOController extends AppBaseController
{
    /**
     * Display a listing of the CLO.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var CLO $cLOS */
        $cLOS = CLO::all();

        return view('c_l_o_s.index')
            ->with('cLOS', $cLOS);
    }

    /**
     * Show the form for creating a new CLO.
     *
     * @return Response
     */
    public function create()
    {
        $period = Period::getAllPeriod();
        $studyPrograms = StudyProgram::getAllProdi();
        $cLO = null;
        return view('c_l_o_s.create', ['period' => $period, 'cLO' => $cLO, 'studyPrograms' => $studyPrograms]);
    }

    /**
     * Store a newly created CLO in storage.
     *
     * @param CreateCLORequest $request
     *
     * @return Response
     */
    public function store(CreateCLORequest $request)
    {

        $input = $request->all();

        //check is 100 in penguji
        if ($request->penguji == 1) {
            $percentage = CLO::where('period_id', $request->period_id)
                ->where('study_program_id', $request->study_program_id)
                ->whereHas('components', function ($query) {
                    $query->where('penguji', 1);
                })
                ->sum('precentage');
            if ($percentage + $request->precentage > 100) {
                Flash::error('Presentase untuk penguji sudah lebih dari 100');
                return redirect()->back();
            }
        }

        //check is 100 in pembimbing
        if ($request->pembimbing == 1) {
            $percentage = CLO::where('period_id', $request->period_id)
                ->where('study_program_id', $request->study_program_id)
                ->whereHas('components', function ($query) {
                    $query->where('pembimbing', 1);
                })
                ->sum('precentage');
            if ($percentage + $request->precentage > 100) {
                Flash::error('Presentase untuk pembimbing sudah lebih dari 100');
                return redirect()->back();
            }
        }


        DB::beginTransaction();
        $clo = CLO::create($input);
        $component = Component::create([
            'code' => $request->code,
            'description' => $request->description,
            'percentage' => $request->precentage,
            'unsur_penilaian' => $request->rubrikasi,
            'pembimbing' => $request->pembimbing,
            'penguji' => $request->penguji,
            'clo_id' => $clo->id,
        ]);
        for ($i = 0; $i < count($request->interval); $i++) {
            Interval::insert([
                'value' => $request->interval[$i],
                'ekuivalensi' => $request->ekuivalensi[$i],
                'component_id' => $component->id,
            ]);
        }
        DB::commit();

        Flash::success('Berhasil Membuat CLO');
        return redirect(route('cLOS.index'));
    }

    /**
     * Display the specified CLO.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CLO $cLO */
        $cLO = CLO::find($id);

        if (empty($cLO)) {
            Flash::error('C L O Tidak Ditemukan');

            return redirect(route('cLOS.index'));
        }

        return view('c_l_o_s.show')->with('cLO', $cLO);
    }

    /**
     * Show the form for editing the specified CLO.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $cLO = CLO::find($id);
        $period = Period::getAllPeriod();
        $studyPrograms = StudyProgram::getAllProdi();

        if (empty($cLO)) {
            Flash::error('C L O Tidak Ditemukan');

            return redirect(route('cLOS.index'));
        }

        return view('c_l_o_s.edit')->with(['cLO' => $cLO, 'period' => $period, 'studyPrograms' => $studyPrograms]);
    }

    /**
     * Update the specified CLO in storage.
     *
     * @param int $id
     * @param UpdateCLORequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCLORequest $request)
    {

        $this->validate($request, [
            'interval' => 'required',
            'ekuivalensi' => 'required'
        ]);

        $cLO = CLO::find($id);
        if (empty($cLO)) {
            Flash::error('C L O Tidak Ditemukan');
            return redirect(route('cLOS.index'));
        }

        //check is 100 in penguji
        if ($request->penguji == 1) {
            if ($cLO['study_program_id'] == null) {
                $percentage = CLO::where('period_id', $request->period_id)
                    ->whereHas('components', function ($query) {
                        $query->where('penguji', 1);
                    })
                    ->sum('precentage');
            } else {
                $percentage = CLO::where('period_id', $request->period_id)
                    ->where('study_program_id', $cLO['study_program'])
                    ->whereHas('components', function ($query) {
                        $query->where('penguji', 1);
                    })
                    ->sum('precentage');
            }
            if ($percentage - $cLO->precentage + $request->precentage > 100) {
                Flash::error('Presentase untuk penguji sudah lebih dari 100');
                return redirect()->back();
            }
        }

        //check is 100 in pembimbing
        if ($request->pembimbing == 1) {
            if ($cLO['study_program_id'] == null) {
                $percentage = CLO::where('period_id', $request->period_id)
                    ->whereHas('components', function ($query) {
                        $query->where('pembimbing', 1);
                    })
                    ->sum('precentage');
            } else {
                $percentage = CLO::where('period_id', $request->period_id)
                    ->where('study_program_id', $cLO['study_program'])
                    ->whereHas('components', function ($query) {
                        $query->where('pembimbing', 1);
                    })
                    ->sum('precentage');
            }
            if ($percentage - $cLO->precentage + $request->precentage > 100) {
                Flash::error('Presentase untuk pembimbing sudah lebih dari 100');
                return redirect()->back();
            }
        }

        DB::beginTransaction();
        $cLO->fill($request->all());
        $cLO->save();
        $component = Component::where('clo_id', $id)
            ->update([
                'code' => $request->code,
                'description' => $request->description,
                'percentage' => $request->percentage,
                'unsur_penilaian' => $request->rubrikasi,
                'pembimbing' => $request->pembimbing,
                'penguji' => $request->penguji,
            ]);
        Interval::where('component_id', $cLO->components[0]->id)->delete();
        for ($i = 0; $i < count($request->interval); $i++) {
            Interval::insert([
                'value' => $request->interval[$i],
                'ekuivalensi' => $request->ekuivalensi[$i],
                'component_id' => $cLO->components[0]->id,
            ]);
        }
        DB::commit();

        Flash::success('C L O Berhasil Di Ubah.');
        return redirect(route('cLOS.index'));
    }

    /**
     * Remove the specified CLO from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $clo = CLO::find($id);

        if (empty($clo)) {
            Flash::error('C L O Tidak Ditemukan');
            return redirect(route('cLOS.index'));
        }

        DB::beginTransaction();
        try {
            Interval::where('component_id', $clo->components[0]->id)->delete();
            Component::where('clo_id', $clo->id)->delete();
            $clo->delete();
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                Flash::error('Gagal Menghapus CLO');
                return redirect(route('cLOS.index'));
            }
        }
        DB::commit();

        Flash::success('C L O Berhasil DIhapus.');

        return redirect(route('cLOS.index'));
    }

    public function preview($period_id, $study_program_id, $role)
    {
        if ($study_program_id == -1) {
            $clos = CLO::where('period_id', $period_id)
                ->where('study_program_id', null)
                ->whereHas('components', function ($query) use ($role) {
                    $query->where($role, 1);
                })
                ->get();
        } else {
            $clos = CLO::where('period_id', $period_id)
                ->where('study_program_id', $study_program_id)
                ->whereHas('components', function ($query) use ($role) {
                    $query->where($role, 1);
                })
                ->get();
        }

        return view('c_l_o_s.preview', [
            'clos' => $clos,
            'role' => $role
        ]);
    }

    public function clone()
    {
        $periods = Period::all();
        $clos = CLO::all();
        $programStudies = StudyProgram::all();

        return view('c_l_o_s.clone')->with([
            'periods' => $periods,
            'clos' => $clos,
            'programStudies' => $programStudies
        ]);
    }

    public function clone_proses(Request $request)
    {

        $this->validate($request, [
            'from_period' => 'required',
            'to_period' => 'required',
        ], [
            'from_period.required' => 'Period asal belum dipilih',
            'to_period.required' => 'Period tujuan belum dipilih'
        ]);

        DB::beginTransaction();
        //delete current clos in to period data
        if ($request->to_prodi == null)
            $clos = CLO::where('period_id', $request->to_period)->where('study_program_id', null)->get();
        else
            $clos = CLO::where('period_id', $request->to_period)->where('study_program_id', $request->to_prodi)->get();
        foreach ($clos as $clo) {
            Interval::where('component_id', $clo->components[0]->id)->delete();
            Component::find($clo->components[0]->id)->delete();
            CLO::find($clo->id)->delete();
        }

        //insert with clone
        if ($request->from_prodi == null)
            $clos_from = CLO::where('period_id', $request->from_period)->where('study_program_id', null)->get();
        else
            $clos_from = CLO::where('period_id', $request->from_period)->where('study_program_id', $request->from_prodi)->get();

        foreach ($clos_from as $clo_from) {
            $clo = CLO::create([
                'code' => $clo_from->code,
                'precentage' => $clo_from->precentage,
                'description' => $clo_from->description,
                'period_id' => $request->to_period,
                'study_program_id' => $request->to_prodi,
            ]);
            $component = Component::create([
                'code' => $clo_from->components[0]->code,
                'description' => $clo_from->components[0]->description,
                'percentage' => $clo_from->components[0]->percentage,
                'unsur_penilaian' => $clo_from->components[0]->unsur_penilaian,
                'pembimbing' => $clo_from->components[0]->pembimbing,
                'penguji' => $clo_from->components[0]->penguji,
                'clo_id' => $clo->id,
            ]);
            foreach ($clo_from->components[0]->intervals as $interval) {
                Interval::insert([
                    'value' => $interval->value,
                    'ekuivalensi' => $interval->ekuivalensi,
                    'component_id' => $component->id,
                ]);
            }
        }
        DB::commit();
        Flash::success('Berhasil clone');
        return redirect(route('cLOS.index'));
    }
}
