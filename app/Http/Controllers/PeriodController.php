<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use App\Models\Period;
use App\Repositories\PeriodRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\User;
use Flash;
use Response;
use Auth;

class PeriodController extends AppBaseController
{
    /** @var  PeriodRepository */
    private $periodRepository;

    public function __construct(PeriodRepository $periodRepo)
    {
        $this->periodRepository = $periodRepo;
    }

    /**
     * Display a listing of the Period.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $periods = $this->periodRepository->all();

        return view('periods.index')
            ->with('periods', $periods);
    }

    /**
     * Show the form for creating a new Period.
     *
     * @return Response
     */
    public function create()
    {
        return view('periods.create');
    }

    /**
     * Store a newly created Period in storage.
     *
     * @param CreatePeriodRequest $request
     *
     * @return Response
     */
    public function store(CreatePeriodRequest $request)
    {
        $input = $request->all();

        if($input['start_date'] >= $input['end_date'])
            return redirect()->back()
                    ->withInput()
                    ->withErrors("Tanggal akhir tidak sesuai. Mohon cek kembali");
        elseif (Period::isPeriodSame($input['start_date'],$input['end_date']))
            return redirect()->back()
                ->withInput()
                ->withErrors("rentang waktu sama dengan period lain. Mohon cek kembali");
        elseif (Period::isPeriodSameDescription($input['name']))
            return redirect()->back()
                ->withInput()
                ->withErrors("nama period sama dengan period lain. Mohon cek kembali");

        $period = $this->periodRepository->create($input);

        Flash::success('Period Berhasil Disimpan');

        return redirect(route('periods.index'));
    }

    /**
     * Display the specified Period.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $period = $this->periodRepository->find($id);

        if (empty($period)) {
            Flash::error('Period Tidak Ada');

            return redirect(route('periods.index'));
        }

        return view('periods.show')->with('period', $period);
    }

    /**
     * Show the form for editing the specified Period.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $period = $this->periodRepository->find($id);

        if (empty($period)) {
            Flash::error('Period Tidak Ada');

            return redirect(route('periods.index'));
        }

        return view('periods.edit')->with('period', $period);
    }

    /**
     * Update the specified Period in storage.
     *
     * @param int $id
     * @param UpdatePeriodRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePeriodRequest $request)
    {
        $period = $this->periodRepository->find($id);

        if (empty($period)) {
            Flash::error('Period Tidak Ada');

            return redirect(route('periods.index'));
        }

        $period = $this->periodRepository->update($request->all(), $id);

        Flash::success('Period Berhasil Disimpan.');

        return redirect(route('periods.index'));
    }

    /**
     * Remove the specified Period from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $period = $this->periodRepository->find($id);

        if (empty($period)) {
            Flash::error('Period Tidak Ada');

            return redirect(route('periods.index'));
        }

        try{
            $this->periodRepository->delete($id);
            Flash::success('Period Berhasil Dihapus.');
        } catch(\Illuminate\Database\QueryException $e)
        {
            Flash::error('Period tidak dapat dihapus karena digunakan pada data lain.');
        }
        return redirect(route('periods.index'));
    }
}
