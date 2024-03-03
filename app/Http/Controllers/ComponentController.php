<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComponentRequest;
use App\Http\Requests\UpdateComponentRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Component;
use App\Models\CLO;
use Illuminate\Http\Request;
use Flash;
use Response;

class ComponentController extends AppBaseController
{
    /**
     * Display a listing of the Component.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Component $components */
        $components = Component::all();

        return view('components.index')
            ->with('components', $components);
    }

    /**
     * Show the form for creating a new Component.
     *
     * @return Response
     */
    public function create($id)
    {

      $clo = CLO::find($id);

      if (empty($clo)) {
          Flash::error('CLO Tidak Ditemukan!');
          return redirect(route('cLOS.index'));
      }

      return view('components.create',['clo' => $clo]);
    }

    /**
     * Store a newly created Component in storage.
     *
     * @param CreateComponentRequest $request
     *
     * @return Response
     */
    public function store(CreateComponentRequest $request)
    {
        $input = $request->all();

        $clo = CLO::find($request->clo_id);
        $percentageCLO =  $clo->precentage;
        $percentageComponent = Component::where('clo_id',$clo->id)->sum('percentage');
        $sisaPercentage = $percentageCLO - $percentageComponent;
        if ($request->percentage > $sisaPercentage) {
          Flash::error('Persen dari komponen melebihi jumlah persen CLO');
          return redirect(route('cLOS.index'));
        }

        $component = Component::create($input);

        Flash::success('Component saved successfully.');

        return redirect(route('components.index'));
    }

    /**
     * Display the specified Component.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Component $component */
        $component = Component::find($id);

        if (empty($component)) {
            Flash::error('Komponen Tidak ada');

            return redirect(route('components.index'));
        }

        return view('components.show')->with('component', $component);
    }

    /**
     * Show the form for editing the specified Component.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $component = Component::find($id);
        if (empty($component)) {
            Flash::error('Komponen Tidak ada');
            return redirect(route('components.index'));
        }

        $clo = $component->clo;
        if (empty($clo)) {
            Flash::error('CLO Tidak Ditemukan!');
            return redirect(route('cLOS.index'));
        }

        return view('components.edit')->with([
          'component' => $component,
          'clo' => $clo
        ]);
    }

    /**
     * Update the specified Component in storage.
     *
     * @param int $id
     * @param UpdateComponentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComponentRequest $request)
    {

        $component = Component::find($id);

        if (empty($component)) {
            Flash::error('Komponen Tidak ada');

            return redirect(route('components.index'));
        }

        $clo = CLO::find($request->clo_id);
        $percentageCLO =  $clo->precentage;
        $percentageComponent = Component::where('clo_id',$clo->id)
        ->where('id', '<>', $id)
        ->sum('percentage');
        $sisaPercentage = $percentageCLO - $percentageComponent;
        if ($request->percentage > $sisaPercentage) {
          Flash::error('Persen dari komponen melebihi jumlah persen CLO');
          return redirect(route('components.index'));
        }

        $component->fill($request->all());
        $component->save();

        Flash::success('Komponen Berhasil Di Ubah.');

        return redirect(route('components.index'));
    }

    /**
     * Remove the specified Component from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Component $component */
        $component = Component::find($id);

        if (empty($component)) {
            Flash::error('Komponen Tidak ada');

            return redirect(route('components.index'));
        }

        try {
          $component->delete();
        } catch (\Exception $e) {
          if ($e->getCode() == 23000) {
            Flash::error('Data Interval masih ada, silahkan hapus terlebih dahulu');
            return redirect(route('components.index'));
          }

        }



        Flash::success('Komponen Berhasil Dihapus.');

        return redirect(route('components.index'));
    }
}
