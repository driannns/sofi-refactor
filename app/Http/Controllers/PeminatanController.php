<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePeminatanRequest;
use App\Http\Requests\UpdatePeminatanRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Peminatan;
use Illuminate\Http\Request;
use Flash;
use Response;

class PeminatanController extends AppBaseController
{
    /**
     * Display a listing of the Peminatan.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Peminatan $peminatans */
        $peminatans = Peminatan::all();

        return view('peminatans.index')
            ->with('peminatans', $peminatans);
    }

    /**
     * Show the form for creating a new Peminatan.
     *
     * @return Response
     */
    public function create()
    {
        return view('peminatans.create');
    }

    /**
     * Store a newly created Peminatan in storage.
     *
     * @param CreatePeminatanRequest $request
     *
     * @return Response
     */
    public function store(CreatePeminatanRequest $request)
    {
        $input = $request->all();

        /** @var Peminatan $peminatan */
        $peminatan = Peminatan::create($input);

        Flash::success('Peminatan Berhasil Disimpan.');

        return redirect(route('peminatans.index'));
    }

    /**
     * Display the specified Peminatan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Peminatan $peminatan */
        $peminatan = Peminatan::find($id);

        if (empty($peminatan)) {
            Flash::error('Peminatan Tidak Ada');

            return redirect(route('peminatans.index'));
        }

        return view('peminatans.show')->with('peminatan', $peminatan);
    }

    /**
     * Show the form for editing the specified Peminatan.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Peminatan $peminatan */
        $peminatan = Peminatan::find($id);

        if (empty($peminatan)) {
            Flash::error('Peminatan Tidak Ada');

            return redirect(route('peminatans.index'));
        }

        return view('peminatans.edit')->with('peminatan', $peminatan);
    }

    /**
     * Update the specified Peminatan in storage.
     *
     * @param int $id
     * @param UpdatePeminatanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePeminatanRequest $request)
    {
        /** @var Peminatan $peminatan */
        $peminatan = Peminatan::find($id);

        if (empty($peminatan)) {
            Flash::error('Peminatan Tidak Ada');

            return redirect(route('peminatans.index'));
        }

        $peminatan->fill($request->all());
        $peminatan->save();

        Flash::success('Peminatan Berhasil DIupdate.');

        return redirect(route('peminatans.index'));
    }

    /**
     * Remove the specified Peminatan from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Peminatan $peminatan */
        $peminatan = Peminatan::find($id);

        if (empty($peminatan)) {
            Flash::error('Peminatan Tidak Ada');

            return redirect(route('peminatans.index'));
        }

        $peminatan->delete();

        Flash::success('Peminatan Berhasil Dihapus.');

        return redirect(route('peminatans.index'));
    }
}
