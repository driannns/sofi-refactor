<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Repositories\TeamRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use Alert;
use DB;

use App\Models\Team;
use App\Models\Student;
use App\Models\User;
use App\Models\Sidang;
use App\Models\DokumenLog;


class TeamController extends AppBaseController
{
    /** @var  TeamRepository */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepo)
    {
        $this->teamRepository = $teamRepo;
    }

    /**
     * Display a listing of the Team.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
//         dd($isIndividu = auth()->user()->student->team->isIndividu(
// auth()->user()->student->nim));
        //check mahasiswa sudah daftar sidang atau belum
        $sidang = Sidang::where('mahasiswa_id', Auth::user()->student->nim)
            ->first();
        if ($sidang == null) {
            return redirect()->back()->
            withError('Anda belum mendaftar sidang, silahkan daftar sidang terlebih dahulu');
        }

        $status = $sidang->status;
        if ($status == "sudah dijadwalkan" || $status == 'tidak lulus (sudah dijadwalkan)') {
            return redirect(route('schedule.mahasiswa'))->
            withError('Jadwal sidang anda sudah diumumkan, tidak dapat membuat team lagi');
        }

        if ($status == "tidak lulus") {
            return redirect(route('slides.index'))->
            withError('Silahkan update berkas sidang ulang dan slide!');
        }

        //check sidang mahasiswa sudah di acc dosen dan pembimbing atau belum
        if ($status != "telah disetujui admin" &&
            $status != "belum dijadwalkan" &&
            $status != "tidak lulus (sudah update dokumen)" &&
            $status != "tidak lulus (belum dijadwalkan)") {
            return redirect(route('sidangs.edit', $sidang->id))->
            withError('Sidang anda belum di approve dosen pembimbing dan admin');
        }

        //check sudah upload ppt belum
        $slide = DokumenLog::where('sidang_id', $sidang->id)
            ->where('jenis', 'slide')
            ->orderBy('id', 'desc')
            ->first();
        if (empty($slide)) {
            Flash::error('Anda harus mengupload berkas presentasi terlebih dahulu!');
            return redirect(route('slides.index'));
        }

        //check dia sudah punya team atau belum
        $team_id = 0;
        if ($team_id = Auth::user()->student->team_id != 0) {
            if ($status == "tidak lulus (sudah update dokumen)") {
                return view('teams.create');
            }
            $team_id = Auth::user()->student->team_id;
        } else {
            return view('teams.create');
        }

        $team = Team::find($team_id);
        $members = Student::where('team_id', $team_id)
            ->get();

        $students = Student::where('team_id', 0)
            ->whereHas('sidangs', function ($query) {
                $query->whereIn('status', ['telah disetujui admin', 'tidak lulus (sudah update dokumen)']);
            })
            ->get();

        return view('teams.index', compact('members', 'team', 'students'));
    }

    /**
     * Show the form for creating a new Team.
     *
     * @return Response
     */
    public function create()
    {
        return view('teams.create');

    }

    /**
     * Store a newly created Team in storage.
     *
     * @param CreateTeamRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:teams',
        ], [
            'unique' => 'Nama Tim TIdak Boleh Sama.',
        ]);
        $student = Student::where('user_id', Auth::user()->id)
            ->first();
        $lastId = Team::max('id');
        $sidang = Sidang::where('mahasiswa_id', $student->nim)->orderBy('created_at', 'desc')->first();

        if ($sidang->status == 'tidak lulus (sudah update dokumen)')
        {
            $count = Student::where('team_id', $student->team_id)
                ->count();
            Student::where('nim', $student->nim)->update([
                'team_id' => 0,
            ]);

            if ($count <= 1) {
                Team::where('id', $student->team_id)
                    ->delete();
            }
        }

        Team::insert([
            'id' => $lastId + 1,
            'name' => $request->name,
        ]);
        $lastId = Team::max('id');

        Student::where('user_id', Auth::user()->id)
            ->update([
                'team_id' => $lastId,
            ]);

        if ($sidang->status == 'tidak lulus (sudah update dokumen)') {
            $this->changeStatusMemberTeam($student->nim, "tidak lulus (belum dijadwalkan)");
            StatusLogController::addStatusLog($sidang->id, "-", 'pengajuan', 'tidak lulus (belum dijadwalkan)');
        } else {
            $this->changeStatusMemberTeam($student->nim, "belum dijadwalkan");
            StatusLogController::addStatusLog($sidang->id, "-", 'penjadwalan', 'belum dijadwalkan');
        }

        Flash::success('Berhasil Membuat Team');

        return redirect(route('teams.index'));
        // }


    }

    /**
     * Display the specified Team.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('Tim Tidak Ada');

            return redirect(route('teams.index'));
        }

        return view('teams.show')->with('team', $team);
    }

    /**
     * Show the form for editing the specified Team.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('Tim Tidak Ada');

            return redirect(route('teams.index'));
        }

        return view('teams.edit')->with('team', $team);
    }

    /**
     * Update the specified Team in storage.
     *
     * @param int $id
     * @param UpdateTeamRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:teams',
        ], [
            'unique' => 'Nama Tim TIdak Boleh Sama.',
        ]);
        $team = $this->teamRepository->find($id);

        if (empty($team)) {
            Flash::error('Tim Tidak Ada');

            return redirect(route('teams.index'));
        }

        $team = $this->teamRepository->update($request->all(), $id);

        Flash::success('Tim Berhasil Di Ubah.');

        return redirect(route('teams.index'));
    }

    /**
     * Remove the specified Team from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($nim)
    {

        $team_id = Auth::user()->student->team_id;
        $count = Student::where('team_id', $team_id)
            ->count();

        Student::where('nim', $nim)->update([
            'team_id' => 0,
        ]);

        if ($count <= 1) {
            Team::where('id', $team_id)
                ->delete();
        }

        $student = Student::where('nim', $nim)->first();

        $sidang = Sidang::where('mahasiswa_id', $nim)->orderBy('created_at', 'desc')->first();
        if ($sidang->status == 'tidak lulus (belum dijadwalkan)') {
            $this->changeStatusMemberTeam($student->nim, "tidak lulus (sudah update dokumen)");
            StatusLogController::addStatusLog($sidang->id, "-", 'pengajuan', 'tidak lulus (sudah update dokumen)');
        } else {
            $this->changeStatusMemberTeam($student->nim, "telah disetujui admin");
            StatusLogController::addStatusLog($sidang->id, "-", 'pengajuan', 'telah disetujui admin');
        }

        Flash::success($nim . ' Berhasil Dihapus.');

        return redirect(route('teams.index'));
    }

    public function createMember()
    {

        $team_id = Auth::user()->student->team_id;

        $students = Student::where('team_id', 0)
            ->whereHas('sidangs', function ($query) {
                $query->whereIn('status', ['telah disetujui admin', 'tidak lulus (sudah update dokumen)']);
            })
            ->get();
        return view('teams.create-member', ['students' => $students]);

    }

    public function storeMember(Request $request)
    {

        $this->validate($request, [
            'nim' => 'required'
        ]);

        //cek jumlah team
        $team_id = Auth::user()->student->team_id;
        $countMembers = Student::where('team_id', $team_id)
            ->count();
        if ($countMembers >= 4) {
            return redirect()->back()->withErrors('Maaf, Jumlah Anggota TIM Anda Melebihi Maksimal');
        }

        Student::where('nim', $request->nim)
            ->update([
                'team_id' => Auth::user()->student->team_id,
            ]);

        $student = Student::where('nim', $request->nim)->first();

        $sidang = Sidang::where('mahasiswa_id', $student->nim)->orderBy('created_at', 'desc')->first();
        if ($sidang->status == 'tidak lulus (sudah update dokumen)') {
            $this->changeStatusMemberTeam($student->nim, "tidak lulus (belum dijadwalkan)");
            StatusLogController::addStatusLog($sidang->id, "-", 'pengajuan', 'tidak lulus (belum dijadwalkan)');
        } else {
            $this->changeStatusMemberTeam($student->nim, "belum dijadwalkan");
            StatusLogController::addStatusLog($sidang->id, "-", 'penjadwalan', 'belum dijadwalkan');
        }

        $this->sendNotification($student->user->username, "Invite Team", "Anda Berhasil Ditambahkan Ke Dalam Team", "/teams");

        Flash::success($request->nim . ' Berhasil Ditambahkan.');

        return redirect(route('teams.index'));
    }

    public function individuSidang()
    {
        $lastId = Team::max('id');
        Team::insert([
            'id' => $lastId + 1,
            'name' => Auth::user()->student->nim . " Sidang Individu",
        ]);
        $lastId = Team::max('id');

        Student::where('user_id', Auth::user()->id)
            ->update([
                'team_id' => $lastId,
            ]);

        $student = Student::where('user_id', Auth::user()->id)->first();

        $sidang = Sidang::where('mahasiswa_id', $student->nim)->orderBy('created_at', 'desc')->first();
        if ($sidang->status == 'tidak lulus (sudah update dokumen)') {
            $this->changeStatusMemberTeam($student->nim, "tidak lulus (belum dijadwalkan)");
            StatusLogController::addStatusLog($sidang->id, "-", 'pengajuan', 'tidak lulus (belum dijadwalkan)');
        } else {
            $this->changeStatusMemberTeam($student->nim, "belum dijadwalkan");
            StatusLogController::addStatusLog($sidang->id, "-", 'penjadwalan', 'belum dijadwalkan');
        }

        Flash::success('Berhasil Mengajukan Sidang Individu');

        return redirect(route('teams.index'));
    }

    private function changeStatusMemberTeam($nim, $status)
    {
        Sidang::where('mahasiswa_id', $nim)
            ->update([
                'status' => $status
            ]);
    }
}
