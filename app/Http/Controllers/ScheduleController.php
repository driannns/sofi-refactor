<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Schedule;
use App\Models\Sidang;
use App\Models\Team;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\DokumenLog;
use Illuminate\Http\Request;
use Flash;
use Response;
use Redirect;
use Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Schema;
use App\Models\Datapoint;
use App\Models\Sensor;

class ScheduleController extends AppBaseController
{

    public function __construct()
    {
        //Add permission for spesific method
        //Permission must add per method and you choose what role can access
        $this->middleware('checkRole:RLPIC', ['only' => ['index', 'create', 'destroy']]);
        $this->middleware('checkRole:RLMHS', ['only' => ['indexMahasiswa']]);
        $this->middleware('checkRole:RLPGJ,RLPBB', ['only' => ['indexPenguji', 'indexPembimbing']]);
        $this->middleware('checkRole:RLADM,RLSPR', ['only' => ['indexAdmin', 'show_status_revisi']]);
        $this->middleware('checkRole:RLADM,RLPIC,RLPGJ,RLPBB', ['only' => ['show']]);
    }

    /**
     * Display a listing of the Schedule.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userInfo = Auth::user();
        $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')
            ->whereHas('sidang.mahasiswa', function ($query) use ($userInfo) {
                $query->where('kk', $userInfo->lecturer->kk);
            })
            ->get();
        $documents = DokumenLog::where('jenis', 'slide')->get();
        return view('schedules.index')->with([
            'schedules' => $schedules,
            'documents' => $documents,
        ]);
    }

    public function indexAdmin(Request $request)
    {
        $userInfo = Auth::user();
        if ($request->is('schedule/admin')) {
            $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')
                ->whereIn('keputusan', ['lulus', 'lulus bersyarat', null])
                ->get();
        }else if( $request->is('schedule/admin-before') )
        {
            $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')
                ->whereIn('status', ['belum dilaksanakan', 'sedang dilaksanakan', null])
                ->get();
        }else if ($request->is('schedule/superadmin')) {
            $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')
                ->whereIn('keputusan', ['lulus', 'lulus bersyarat', null])
                ->get();
        }else{
            abort(403, 'Unauthorized action.');
        }
        return view('schedules.index')->with([
            'schedules' => $schedules
        ]);
    }

    public function indexPIC(Request $request)
    {
        $userInfo = Auth::user();
        $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa', 'sidang.mahasiswa')
            ->where('keputusan', 'lulus bersyarat')
            ->whereHas('sidang.mahasiswa', function ($query) use ($userInfo) {
                $query->where('kk', $userInfo->lecturer->kk);
            })
            ->orWhere('keputusan', null)
            ->get();
        return view('schedules.index')->with([
            'schedules' => $schedules
        ]);
    }

    public function addFlag(Request $request, $id)
    {
        $filter = $request->query('code');
        $schedule = Schedule::find($id);
        if ($filter == 'rev')
            $schedule->flag_add_revision = true;
        else if ($filter == 'scr')
            $schedule->flag_change_scores = true;
        else
            abort(403, 'Unauthorized action.');
        $schedule->update();

        Flash::success('Berhasil menambahkan akses');
        return redirect(route('schedule.admin'));
    }

    public function indexAdminBermasalah(Request $request)
    {
        $userInfo = Auth::user();
        if ($request->is('schedule/bermasalahSuperAdmin')) {
            $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')->whereHas('sidang', function ($query) {
                $query->whereIn('status', ['tidak lulus']);
            })->orWhereHas('revisions', function ($query) {
                $query->whereIn('status', ['sudah dikirim', 'sedang dikerjakan']);
            })->where('date', '!=', now())->orderBy('date', 'desc')->get();
        } else {
            $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')->whereHas('sidang', function ($query) {
                $query->whereIn('status', ['sudah dijadwalkan', 'tidak lulus (sudah dijadwalkan)']);
            })->orWhereHas('revisions', function ($query) {
                $query->whereIn('status', ['sudah dikirim', 'sedang dikerjakan']);
            })
                ->whereIn('status', ['sedang dilaksanakan', 'telah dilaksanakan'])->where('date', '!=', now())->orderBy('date', 'desc')->get();
        }
        return view('schedules.index')->with([
            'schedules' => $schedules,
        ]);
    }

    public function indexMahasiswa()
    {
        $user = auth()->user();
        $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa', 'sidang.mahasiswa.team')
            ->whereHas('sidang', function ($query) use ($user) {
                $query->where('mahasiswa_id', $user->student->nim);
            })
            ->get();

        $teams = Schedule::with('sidang.mahasiswa')
            ->whereHas('sidang.mahasiswa', function ($query) use ($user) {
                $query->where('team_id', $user->student->team_id);
            })
            ->get();

        $documents = DokumenLog::where('jenis', 'slide')->get();
        return view('schedules.index')->with([
            'schedules' => $schedules,
            'teams' => $teams,
            'documents' => $documents,
        ]);
    }

    public function indexPembimbing()
    {
        $user = auth()->user();
        $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')
            ->whereHas('sidang', function ($query) use ($user) {
                $query->where('pembimbing1_id', $user->lecturer->id)
                    ->orWhere('pembimbing2_id', $user->lecturer->id);
            })
            ->get();
        $documents = DokumenLog::where('jenis', 'slide')->get();
        return view('schedules.index')->with([
            'schedules' => $schedules,
            'documents' => $documents,
        ]);
    }

    public function indexPenguji()
    {
        $user = auth()->user();
        $schedules = Schedule::with('sidang', 'detailpenguji1', 'detailpenguji2', 'sidang.pembimbing1', 'sidang.pembimbing2', 'sidang.mahasiswa')
            ->where('penguji1', $user->lecturer->id)
            ->orWhere('penguji2', $user->lecturer->id)
            ->get();
        $documents = DokumenLog::where('jenis', 'slide')->get();
        return view('schedules.index')->with([
            'schedules' => $schedules,
            'documents' => $documents,
        ]);
    }

    /**
     * Show the form for creating a new Schedule.
     *
     * @return Response
     */
    public function create($id)
    {
        $team = Team::find($id);
        $students = Student::with('sidangs', 'user', 'sidangs.pembimbing1', 'sidangs.pembimbing2')
            ->where('team_id', $id)
            ->get();

        //get excecption penguji
        $penguji = array();
        foreach ($students as $student) {
            $penguji[] = $student->sidangs[0]->pembimbing1->id;
            $penguji[] = $student->sidangs[0]->pembimbing2->id;
        }

        foreach ($students as $carikk) {
            # code...
            $kk = $carikk->kk;
        }

        $penguji1 = Lecturer::where('jfa', '!=', 'NJFA')
            ->whereNotIn('id', $penguji)
            ->get();
        $penguji2 = Lecturer::all();
        $schedule = null;

        return view('schedules.create', compact('schedule', 'team', 'students', 'penguji1', 'penguji2'));
    }

    /**
     * Store a newly created Schedule in storage.
     *
     * @param CreateScheduleRequest $request
     *
     * @return Response
     */
    public function store(CreateScheduleRequest $request)
    {

        //cek tanggal lampau atau belum
        $currentDateTime = Carbon::createFromFormat('Y-m-d H:i', $request->date . " " . $request->time);
        if (Carbon::now() > $currentDateTime) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['date' => 'Waktu sidang sudah lewat']);
        }

        //cek h - 2 jam
        $currentDate = Carbon::createFromFormat('Y-m-d', $request->date);
        if ($request->date == Carbon::now()->format('Y-m-d')) {
            $timeStart = $request->time;
            $batasBawah = date('H:i', (strtotime($timeStart) - 60 * 60 * 2));
            $timeNow = Carbon::now()->format('H:i');
            if ($timeNow > $batasBawah) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['date' => 'maksimal jadwal sidang h-2 jam']);
            }
        }

        //cek apakah penguji 1 dan 2 sama
        if ($request->penguji1 == $request->penguji2) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Penguji 1 Tidak boleh sama dengan Penguji 2']);
        }

        $penguji1 = Lecturer::find($request->penguji1);
        $penguji2 = Lecturer::find($request->penguji2);

        //cek apakah peminatan sama
        $isSama = false;
        for ($i = 0; $i < count($request->nim); $i++) {
            $student = student::where('nim', $request->nim[$i])
                ->first();
            if (($student->kk == $penguji1->kk) || ($student->kk == $penguji2->kk)) {
                $isSama = true;
            }
        }
        if (!$isSama) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Minimal harus ada 1 penguji dari KK yang sama']);
        }

        //cek jfa
        if ($penguji1->jfa == "NJFA") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Penguji 1 harus memiliki JFA.']);
        }

        //exception penguji != pembimbing
        for ($i = 0; $i < count($request->nim); $i++) {
            $sidang = Sidang::find($request->sidang_id[$i]);
            if ($sidang->pembimbing1_id == $request->penguji1 || $sidang->pembimbing1_id == $request->penguji2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['penguji1' => 'Penguji 1 atau Penguji 2 tidak boleh sama dengan pembimbing']);
            } else if ($sidang->pembimbing2_id == $request->penguji1 || $sidang->pembimbing2_id == $request->penguji2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['penguji1' => 'Penguji 1 atau Penguji 2 tidak boleh sama dengan pembimbing']);
            }
        }

        $timeStart = $request->time;
        $timeEnd = date('H:i', (strtotime($timeStart) + 60 * 58 * 2));
        $batasBawah = date('H:i', (strtotime($timeStart) - 60 * 58 * 2));
        $batasAtas = date('H:i', (strtotime($timeEnd) + 0));

        //cek ketersediaan ruangan
        $schedule = Schedule::where('date', $request->date)
            ->where('ruang', $request->ruang)
            ->where(function ($query) use ($batasBawah, $batasAtas) {
                $query->whereTime('time', '>', $batasBawah)
                    ->whereTime('time', '<', $batasAtas);
            })
            // ->where(function ($query) use($timeStart, $timeEnd) {
            //        $query->whereTime('time', '>=', $timeStart)
            //        ->whereTime('time', '<=', $timeEnd);
            // })
            // ->where(function ($query) use($timeStart, $batasBawah) {
            //         $query->whereTime('time', '>', $batasBawah)
            //         ->whereTime('time', '<=', $timeStart);
            // })
            // ->where(function ($query) use($batasAtas, $timeEnd) {
            //         $query->whereTime('time', '>=', $timeEnd)
            //         ->whereTime('time', '<=', $batasAtas);
            // })
            ->get();

        if ($schedule != "[]") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['time' => 'Waktu dan Ruangan bertabrakan']);
        }

        //cek ketersediaan penguji 1
        $schedule = Schedule::where('date', $request->date)
            ->where('penguji1', $request->penguji1)
            ->where(function ($query) use ($batasBawah, $batasAtas) {
                $query->whereTime('time', '>', $batasBawah)
                    ->whereTime('time', '<', $batasAtas);
            })
            // ->where(function ($query) use($timeStart, $timeEnd) {
            //        $query->whereTime('time', '>', $timeStart)
            //        ->whereTime('time', '<', $timeEnd);
            // })
            // ->orWhere(function ($query) use($timeStart, $batasBawah) {
            //         $query->whereTime('time', '>', $batasBawah)
            //         ->whereTime('time', '<', $timeStart);
            // })
            // ->orWhere(function ($query) use($batasAtas, $timeEnd) {
            //         $query->whereTime('time', '>', $timeEnd)
            //         ->whereTime('time', '<', $batasAtas);
            // })
            ->get();

        if ($schedule != "[]") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Waktu Penguji 1 bertabrakan']);
        }

        //cek ketersediaan penguji 2
        $schedule = Schedule::where('date', $request->date)
            ->where('penguji2', $request->penguji2)
            ->where(function ($query) use ($batasBawah, $batasAtas) {
                $query->whereTime('time', '>', $batasBawah)
                    ->whereTime('time', '<', $batasAtas);
            })
            // ->where(function ($query) use($timeStart, $timeEnd) {
            //        $query->whereTime('time', '>', $timeStart)
            //        ->whereTime('time', '<', $timeEnd);
            // })
            // ->orWhere(function ($query) use($timeStart, $batasBawah) {
            //         $query->whereTime('time', '>', $batasBawah)
            //         ->whereTime('time', '<', $timeStart);
            // })
            // ->orWhere(function ($query) use($batasAtas, $timeEnd) {
            //         $query->whereTime('time', '>', $timeEnd)
            //         ->whereTime('time', '<', $batasAtas);
            // })
            ->get();

        if ($schedule != "[]") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji2' => 'Waktu Penguji 2 bertabrakan']);
        }

        for ($i = 0; $i < count($request->nim); $i++) {
            //get slide name
            $slide_name = null;
            $slide = DokumenLog::where('sidang_id', $request->sidang_id[$i])
                ->where('jenis', 'slide')
                ->orderBy('id', 'desc')
                ->first();
            if (!empty($slide)) {
                $slide_name = $slide->nama;
            }

            Schedule::insert([
                'sidang_id' => $request->sidang_id[$i],
                'date' => $request->date,
                'time' => $request->time,
                'ruang' => $request->ruang,
                'penguji1' => $request->penguji1,
                'penguji2' => $request->penguji2,
                'status' => "belum dilaksanakan",
                'created_at' => Carbon::now(),
                'presentasi_file' => $slide_name,
            ]);

            if ($sidang->status == 'tidak lulus (belum dijadwalkan)') {
                Sidang::find($request->sidang_id[$i])
                    ->update([
                        'status' => 'tidak lulus (sudah dijadwalkan)'
                    ]);
                StatusLogController::addStatusLog($request->sidang_id[$i], "-", "penjadwalan", "tidak lulus (sudah dijadwalkan)");
            } else {
                Sidang::find($request->sidang_id[$i])
                    ->update([
                        'status' => 'sudah dijadwalkan'
                    ]);
                StatusLogController::addStatusLog($request->sidang_id[$i], "-", "penjadwalan", "sudah dijadwalkan");
            }

            StatusLogController::addStatusLog($request->sidang_id[$i], "-", "sidang", "belum dilaksanakan");

            $title = "Penjadwalan Sidang";
            $message = "Jadwal sidang anda sudah ditetapkan!";
            $url = "/schedules";
            $this->sendNotification($request->nim[$i], $title, $message, $url);
        }

        Flash::success('Berhasil Menjadwalkan');

        return redirect(route('schedules.index'));
    }

    /**
     * Display the specified Schedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Schedule $schedule */
        $schedule = Schedule::find($id);

        if (empty($schedule)) {
            Flash::error('Jadwal Sidang KK Tidak Ada');

            return redirect(route('schedules.index'));
        }

        $documents = DokumenLog::where('sidang_id', $schedule->sidang->id)->get();
        return view('schedules.show')->with([
            'schedule' => $schedule,
            'documents' => $documents,
        ]);
    }

    /**
     * Show the form for editing the specified Schedule.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {

        $schedule = Schedule::find($id);

        //cek apakah h - 2
        $currentDate = date('Y-m-d', strtotime($schedule->date));
        if ($schedule->date == Carbon::now()->format('Y-m-d')) {
            $timeStart = $schedule->time;
            $batasBawah = date('H:i', (strtotime($timeStart) - 60 * 60 * 2));
            $timeNow = Carbon::now()->format('H:i');
            if ($timeNow > $batasBawah) {
                Flash::error('Maksimal merubah jadwal sidang h - 2 jam');
                return redirect(route('schedules.index'));
            }
        }

        //get all data needed in schedule edit page
        $team_id = $schedule->sidang->mahasiswa->team->id;
        $team = Team::find($team_id);
        $students = Student::with('sidangs', 'user', 'sidangs.pembimbing1', 'sidangs.pembimbing2')
            ->where('team_id', $team_id)
            ->get();

        //get excecption penguji
        $penguji = array();
        foreach ($students as $student) {
            $penguji[] = $student->sidangs[0]->pembimbing1->id;
            $penguji[] = $student->sidangs[0]->pembimbing2->id;
        }

        $penguji1 = Lecturer::where('jfa', '!=', 'NJFA')
            ->whereNotIn('id', $penguji)
            ->get();
        $penguji2 = Lecturer::whereNotIn('id', $penguji)
            ->get();

        //check if exist
        if (empty($schedule)) {
            Flash::error('Jadwal Sidang KK Tidak Ada');
            return redirect(route('schedules.index'));
        }

        return view('schedules.edit', compact('schedule', 'team', 'students', 'penguji1', 'penguji2'));
    }

    /**
     * Update the specified Schedule in storage.
     *
     * @param int $id
     * @param UpdateScheduleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateScheduleRequest $request)
    {

        //cek apakah penguji 1 dan 2 sama
        if ($request->penguji1 == $request->penguji2) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Penguji 1 Tidak boleh sama dengan Penguji 2']);
        }

        $penguji1 = Lecturer::find($request->penguji1);
        $penguji2 = Lecturer::find($request->penguji2);

        //cek apakah peminatan sama
        $isSama = false;
        for ($i = 0; $i < count($request->nim); $i++) {
            $student = student::where('nim', $request->nim[$i])
                ->first();
            if (($student->kk == $penguji1->kk) || ($student->kk == $penguji2->kk)) {
                $isSama = true;
            }
        }
        if (!$isSama) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Minimal harus ada 1 penguji dari KK yang sama']);
        }

        //cek jfa
        if ($penguji1->jfa == "NJFA") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Penguji 1 harus memiliki JFA.']);
        }

        //exception penguji != pembimbing
        for ($i = 0; $i < count($request->nim); $i++) {
            $sidang = Sidang::find($request->sidang_id[$i]);
            if ($sidang->pembimbing1_id == $request->penguji1 || $sidang->pembimbing1_id == $request->penguji2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['penguji1' => 'Penguji 1 atau Penguji 2 tidak boleh sama dengan pembimbing']);
            } else if ($sidang->pembimbing2_id == $request->penguji1 || $sidang->pembimbing2_id == $request->penguji2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['penguji1' => 'Penguji 1 atau Penguji 2 tidak boleh sama dengan pembimbing']);
            }
        }

        $timeStart = $request->time;
        $timeEnd = date('H:i', (strtotime($timeStart) + 60 * 58 * 2));
        $batasBawah = date('H:i', (strtotime($timeStart) - 60 * 58 * 2));
        $batasAtas = date('H:i', (strtotime($timeEnd) + 0));

        //get tim schedule id
        $team_id = Schedule::find($id)->sidang->mahasiswa->team_id;

        //cek ketersediaan ruangan
        $schedule = Schedule::with('sidang.mahasiswa')
            ->whereHas('sidang.mahasiswa', function ($query) use ($team_id) {
                $query->where('team_id', '!=', $team_id);
                $query->orWhere('team_id', '==', 0);
            })->where('id', '<>', $id)
            ->where('date', $request->date)
            ->where('ruang', $request->ruang)
            ->where(function ($query) use ($batasBawah, $batasAtas) {
                $query->whereTime('time', '>', $batasBawah)
                    ->whereTime('time', '<', $batasAtas);
            })
            // ->where(function ($query) use($timeStart, $timeEnd) {
            //        $query->whereTime('time', '>', $timeStart)
            //        ->whereTime('time', '<', $timeEnd);
            // })
            // ->orWhere(function ($query) use($timeStart, $batasBawah) {
            //         $query->whereTime('time', '>', $batasBawah)
            //         ->whereTime('time', '<', $timeStart);
            // })
            // ->orWhere(function ($query) use($batasAtas, $timeEnd) {
            //         $query->whereTime('time', '>', $timeEnd)
            //         ->whereTime('time', '<', $batasAtas);
            // })
            ->get();

        if ($schedule != "[]") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['time' => 'Waktu dan Ruangan bertabrakan']);
        }

        //cek ketersediaan penguji 1
        $schedule = Schedule::with('sidang.mahasiswa')
            ->whereHas('sidang.mahasiswa', function ($query) use ($team_id) {
                $query->where('team_id', '!=', $team_id);
                $query->orWhere('team_id', '==', 0);
            })->where('id', '<>', $id)
            ->where('date', $request->date)
            ->where('penguji1', $request->penguji1)
            ->where(function ($query) use ($batasBawah, $batasAtas) {
                $query->whereTime('time', '>', $batasBawah)
                    ->whereTime('time', '<', $batasAtas);
            })
            // ->where(function ($query) use($timeStart, $timeEnd) {
            //        $query->whereTime('time', '>', $timeStart)
            //        ->whereTime('time', '<', $timeEnd);
            // })
            // ->orWhere(function ($query) use($timeStart, $batasBawah) {
            //         $query->whereTime('time', '>', $batasBawah)
            //         ->whereTime('time', '<', $timeStart);
            // })
            // ->orWhere(function ($query) use($batasAtas, $timeEnd) {
            //         $query->whereTime('time', '>', $timeEnd)
            //         ->whereTime('time', '<', $batasAtas);
            // })
            ->get();
        if ($schedule != "[]") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji1' => 'Waktu Penguji 1 bertabrakan']);
        }

        //cek ketersediaan penguji 2
        $schedule = Schedule::with('sidang.mahasiswa')
            ->whereHas('sidang.mahasiswa', function ($query) use ($team_id) {
                $query->where('team_id', '!=', $team_id);
                $query->orWhere('team_id', '==', 0);
            })->where('id', '<>', $id)
            ->where('date', $request->date)
            ->where('penguji2', $request->penguji2)
            ->where(function ($query) use ($batasBawah, $batasAtas) {
                $query->whereTime('time', '>', $batasBawah)
                    ->whereTime('time', '<', $batasAtas);
            })
            // ->where(function ($query) use($timeStart, $timeEnd) {
            //        $query->whereTime('time', '>', $timeStart)
            //        ->whereTime('time', '<', $timeEnd);
            // })
            // ->orWhere(function ($query) use($timeStart, $batasBawah) {
            //         $query->whereTime('time', '>', $batasBawah)
            //         ->whereTime('time', '<', $timeStart);
            // })
            // ->orWhere(function ($query) use($batasAtas, $timeEnd) {
            //         $query->whereTime('time', '>', $timeEnd)
            //         ->whereTime('time', '<', $batasAtas);
            // })
            ->get();

        if ($schedule != "[]") {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['penguji2' => 'Waktu Penguji 2 bertabrakan']);
        }

        //check schedule exists
        $schedule_exist = Schedule::find($id);
        if (empty($schedule_exist)) {
            Flash::error('Jadwal Sidang KK Tidak Ada');

            return redirect(route('schedules.index'));
        }

        for ($i = 0; $i < count($request->nim); $i++) {
            Schedule::where('sidang_id', $request->sidang_id[$i])
                ->update([
                    'date' => $request->date,
                    'time' => $request->time,
                    'ruang' => $request->ruang,
                    'penguji1' => $request->penguji1,
                    'penguji2' => $request->penguji2,
                    'status' => "belum dilaksanakan",
                    'updated_at' => Carbon::now(),
                ]);
            $title = "Penjadwalan Sidang";
            $message = "Jadwal sidang anda ada perubahan!";
            $url = "/schedules";
            $this->sendNotification($request->nim[$i], $title, $message, $url);
        }

        Flash::success('Jadwal Berhasil Diubah');

        return redirect(route('schedules.index'));
    }

    /**
     * Remove the specified Schedule from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($team_id)
    {
        Schema::disableForeignKeyConstraints();
        $students = Student::where('team_id', $team_id)->get();
        for ($i = 0; $i < count($students); $i++) {
            $sidang = Sidang::where('mahasiswa_id', $students[$i]->nim)->first();
            $schedule = Schedule::where('sidang_id', $sidang->id)->orderBy('created_at', 'desc')->first();
            Schedule::where('id', $schedule->id)->delete();
            if ($sidang->status == 'tidak lulus (sudah dijadwalkan)') {
                $sidang->update([
                    'status' => 'tidak lulus (belum dijadwalkan)'
                ]);
                StatusLogController::addStatusLog($sidang->id, "-", "penjadwalan", "tidak lulus (belum dijadwalkan)");
            } else {
                $sidang->update([
                    'status' => 'belum dijadwalkan'
                ]);
                StatusLogController::addStatusLog($sidang->id, "-", "penjadwalan", "belum dijadwalkan");
            }
        }

        Schema::enableForeignKeyConstraints();
        Flash::success('Berhasil menghapus jadwal');
        // return redirect(route('schedules.index'));
        return back();
    }

    public function popupView($id)
    {
        /** @var Schedule $schedule */
        $schedule = Schedule::find($id);
        $documents = DokumenLog::where('sidang_id', $schedule->sidang->id)->get();
        return view('schedules.show-popup')->with([
            'schedule' => $schedule,
            'documents' => $documents,
        ]);
    }

    public function berita_acara(Request $request, $schedule_id)
    {
        $schedule = Schedule::find($schedule_id)
            ->update([
                'status' => 'telah dilaksanakan',
            ]);
        Flash::success('Berita acara telah dicetak');
        return redirect(route('schedule.penguji'));
    }

    public function show_berita_acara($schedule_id)
    {
        $schedule = Schedule::find($schedule_id);
        return view('schedules.berita_acara')->with('schedule', $schedule);
    }

    public function show_schedule_list($sidang_id)
    {
        $schedules = Schedule::where('sidang_id', $sidang_id)->get();
        return view('schedules.indexEmbed', compact('schedules'));
    }

    public function show_status_revisi()
    {

        $today = Carbon::today();
        $schedules_durasi_not_null = Schedule::whereHas('revisions', function ($query) {
            $query->whereIn('status', ['sudah dikirim', 'sedang dikerjakan']);
        })
            ->whereNotNull('durasi_revisi')
            ->whereRaw('(? >= DATE(DATE_ADD(date,INTERVAL durasi_revisi-2 DAY)))', [$today])->get();

        $schedule_durasi_null = Schedule::whereHas('revisions', function ($query) {
            $query->whereIn('status', ['sudah dikirim', 'sedang dikerjakan']);
        })
            ->whereNull('durasi_revisi')
            ->whereRaw('(? >= DATE(DATE_ADD(date,INTERVAL 14-2 DAY)))', [$today])->get();

        $schedules = $schedules_durasi_not_null->merge($schedule_durasi_null);

        return view('schedules.status_revisi', compact('schedules'));
    }

    public function get_jadwal_dosen_penguji()
    {
        $filter_dosen = $_GET['f_dosen'];
        // $filter_kk = 'Cybernetics';
        $filter_kk = $_GET['f_kk'];
        $filter_date = $_GET['f_date'];
        // echo $filter_kk;

        $where = [];
        $where2 = [];
        // echo $filter_dosen;
        if ($filter_dosen == 'none' || $filter_dosen != "null") {
            array_push($where, ['schedules.penguji1', '=', $filter_dosen]);
            array_push($where2, ['schedules.penguji2', '=', $filter_dosen]);
            // $where2['schedules.penguji2'] = $filter_dosen;
            // echo "aazza";
        }
        if ($filter_kk != "null") {
            array_push($where, ['lecturers.kk', '=', $filter_kk]);
            array_push($where2, ['lecturers.kk', '=', $filter_kk]);
            // $where2[] = ['lecturers.kk', '=', $filter_kk];
            // $where2['lecturers.kk'] = $filter_kk;
        }
        if ($filter_date != 'none') {
            array_push($where, ['schedules.date', '=', $filter_date]);
            array_push($where2, ['schedules.date', '=', $filter_date]);
            // $where2[] = ['schedules.date', '=', $filter_date];
            // $where2['schedules.date'] = $filter_date;
        }
        // print_r($where);
        // DB::enableQueryLog();
        if (($filter_dosen == 'none' || $filter_dosen == "null") && ($filter_kk == 'none' || $filter_kk == "null") && ($filter_date == 'none' || $filter_date == "null")) {
            $schedules = DB::table('schedules')
                ->join('lecturers', 'lecturers.id', '=', 'schedules.penguji1')
                ->join('users', 'users.id', '=', 'lecturers.user_id')
                ->select('lecturers.*', 'schedules.date', 'users.nama', 'schedules.time', DB::raw('ADDTIME(schedules.time, "2:00") as end_time'))
                ->get()->toArray();
            $merge = $schedules;
            // echo "zzz";
        } else {
            // echo "zzzss";
            $schedules = DB::table('schedules')
                ->join('lecturers', 'lecturers.id', '=', 'schedules.penguji1')
                ->join('users', 'users.id', '=', 'lecturers.user_id')
                ->where($where)
                ->select('lecturers.*', 'schedules.date', 'users.nama', 'schedules.time', DB::raw('ADDTIME(schedules.time, "2:00") as end_time'))
                ->get()->toArray();

            $schedules2 = DB::table('schedules')
                ->join('lecturers', 'lecturers.id', '=', 'schedules.penguji1')
                ->join('users', 'users.id', '=', 'lecturers.user_id')
                ->where($where2)
                ->select('lecturers.*', 'schedules.date', 'users.nama', 'schedules.time', DB::raw('ADDTIME(schedules.time, "2:00") as end_time'))
                ->get()->toArray();

            $merge = array_merge($schedules, $schedules2);
        }
        // dd(DB::getQueryLog());
        return response($merge, 200);
    }

    public function get_select_jadwal_dosen_penguji()
    {
        $type = $_GET['type'];
        if ($type == "dosen") {
            $response = DB::table('lecturers')->join('users', 'users.id', '=', 'lecturers.user_id')->select("users.id", "users.nama", "lecturers.code", "lecturers.nip")->get()->toArray();
        } elseif ($type == "kk") {
            $response = DB::table('lecturers')->whereNotNull('kk')->select("kk")->distinct()->get()->toArray();
        }
        return response($response, 200);
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $penguji1 = $request->penguji1;
            $date = $request->date;
            $time = $request->time;
            $timeconvert = date('H:i', (strtotime($time)));
            $timeconvertup = date('H:i', strtotime('2 hour', strtotime($time)));
            // $products=Schedule::with('detailpenguji1')->where('date','LIKE','%'.$request->date."%")->get();
            if (
                Schedule::where('date', $date)->where('penguji1', $penguji1)->whereTime(DB::raw('ADDTIME(schedules.time, "2:00")'), '>=', $timeconvert)->count() > 0
                && Schedule::where('date', $date)->where('penguji1', $penguji1)->whereTime('time', '<=', $timeconvertup)->count() > 0

            ) {
                $output .= '<div class="alert alert-danger" role="alert">
              Mohon pilih penguji lainnya, Penguji ini sudah memiliki jadwal
        </div>';
                return Response($output);

                //   $idrtime= Schedule::where('date', $date)->where('penguji1',$penguji1)->whereTime('time', '>=', $timeconvert)->limit(1)->get();
                // foreach ($idrtime as $value) {
                //   # code...
                //   $timesc = $value->time;
                // }

                // if(date('H:i',strtotime('+2 hour',strtotime($timesc))) - $timeconvert = 0 ){
                //   $output.= '<div class="alert alert-danger" role="alert">
                //   Mohon pilih penguji lainnya, Penguji ini sudah memiliki jadwal '.date('H:i',strtotime('+2 hour',strtotime($timesc))) - $timeconvert.'
                //     </div>';
                //     return Response($output);
                // }else{
                //   $output.= '<div class="alert alert-success" role="alert">
                //   Penguji ini bersedia '.$timeconvert.'
                //   </div>';
                //   return Response($output);
                // }

            } else {
                $output .= '<div class="alert alert-success" role="alert">
          Penguji ini bersedia </div>';
                return Response($output);
            }
        }
    }


    public function search2(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $penguji2 = $request->penguji2;
            $date = $request->date;
            $time = $request->time;
            // $timeconvert = date('H:i', (strtotime($time)));
            $timeconvert = date('H:i', (strtotime($time)));
            $timeconvertup = date('H:i', strtotime('2 hour', strtotime($time)));

            // $products=Schedule::with('detailpenguji2')->where('date','LIKE','%'.$request->date."%")->get();
            if (
                Schedule::where('date', $date)->where('penguji2', $penguji2)->whereTime(DB::raw('ADDTIME(schedules.time, "2:00")'), '>=', $timeconvert)->count() > 0
                && Schedule::where('date', $date)->where('penguji2', $penguji2)->whereTime('time', '<=', $timeconvertup)->count() > 0
            ) {
                $output .= '<div class="alert alert-danger" role="alert">
                  Mohon pilih penguji lainnya, Penguji ini sudah memiliki jadwal
            </div>';
                return Response($output);
            } else {
                $output .= '<div class="alert alert-success" role="alert">
              Penguji ini bersedia
        </div>';
                return Response($output);
            }
        }
    }
}
