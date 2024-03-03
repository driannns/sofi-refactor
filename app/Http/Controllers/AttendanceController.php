<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;

use Carbon\Carbon;


class AttendanceController extends AppBaseController
{
    /**
     * Display a listing of the Attendance.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Attendance $attendances */
        $attendances = Attendance::all();

        return view('attendances.index')
            ->with('attendances', $attendances);
    }

    /**
     * Show the form for creating a new Attendance.
     *
     * @return Response
     */
    public function create()
    {
        return view('attendances.create');
    }

    /**
     * Store a newly created Attendance in storage.
     *
     * @param CreateAttendanceRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendanceRequest $request)
    {
        $input = $request->all();

        /** @var Attendance $attendance */
        $attendance = Attendance::create($input);

        Flash::success('Kehadiran berhasil disimpan.');

        return redirect(route('attendances.index'));
    }

    /**
     * Display the specified Attendance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            Flash::error('Kehadiran Tidak Ditemukan');

            return redirect(route('attendances.index'));
        }

        return view('attendances.show')->with('attendance', $attendance);
    }

    /**
     * Show the form for editing the specified Attendance.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            Flash::error('Kehadiran Tidak Ditemukan');

            return redirect(route('attendances.index'));
        }

        return view('attendances.edit')->with('attendance', $attendance);
    }

    /**
     * Update the specified Attendance in storage.
     *
     * @param int $id
     * @param UpdateAttendanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendanceRequest $request)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            Flash::error('Kehadiran Tidak Ditemukan');

            return redirect(route('attendances.index'));
        }

        $attendance->fill($request->all());
        $attendance->save();

        Flash::success('Kehadiran Berhasil Diupdate.');

        return redirect(route('attendances.index'));
    }

    /**
     * Remove the specified Attendance from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Attendance $attendance */
        $attendance = Attendance::find($id);

        if (empty($attendance)) {
            Flash::error('Kehadiran Tidak Ditemukan');

            return redirect(route('attendances.index'));
        }

        $attendance->delete();

        Flash::success('Kehadiran Berhasil Dihapus.');

        return redirect(route('attendances.index'));
    }

    public function hadir($id,Request $request)
    {
      $schedule = Schedule::find($id);

      //cek apakah sudah waktunya sidang
      $currentTime = Carbon::now();
      $sidangTime = Carbon::createFromFormat('Y-m-d H:i', $request->date." ".$request->time);

      if (Carbon::now() < $sidangTime) {
        Flash::error('Bukan waktu sidang');
        return redirect()->back();
      }

      $kehadiran = null;
      if (Auth::user()->lecturer != null) {
        if ($schedule->penguji1 == Auth::user()->lecturer->id) {
          $kehadiran = Attendance::hadir($id,Auth::user()->id,'penguji1');
          $schedule->update([
            'status' => 'sedang dilaksanakan'
          ]);
          StatusLogController::addStatusLog($schedule->sidang->id,'-','sidang','sedang dilaksanakan');
        } elseif($schedule->penguji2 == Auth::user()->lecturer->id){
          $kehadiran = Attendance::hadir($id,Auth::user()->id,'penguji2');
        } elseif($schedule->sidang->pembimbing1_id == Auth::user()->lecturer->id){
          $kehadiran = Attendance::hadir($id,Auth::user()->id,'pembimbing1');
        } elseif($schedule->sidang->pembimbing2_id == Auth::user()->lecturer->id){
          $kehadiran = Attendance::hadir($id,Auth::user()->id,'pembimbing2');
        }
      } else {
        $kehadiran = Attendance::hadir($id,Auth::user()->id,'mahasiswa');
      }

      if ($kehadiran) {
        Flash::success('Berhasil Input Kehadiran');
        return redirect()->back();
      }else{
        Flash::success('Gagal Input Kehadiran');
        return redirect()->back();
      }

    }
}
