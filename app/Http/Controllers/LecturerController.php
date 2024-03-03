<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;
use App\Repositories\LecturerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

use App\Models\Lecturer;
use App\Models\Role;
use App\Models\User;

class LecturerController extends AppBaseController
{
    /** @var  LecturerRepository */
    private $lecturerRepository;

    public function __construct(LecturerRepository $lecturerRepo)
    {
        $this->lecturerRepository = $lecturerRepo;
    }

    /**
     * Display a listing of the Lecturer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::all();

        return view('lecturers.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new Lecturer.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::doesntHave('students')->get();
        $roles = Role::whereNotIn('role_code',['RLMHS','RLPBB','RLPGJ'])
              ->get();
        return view('lecturers.create', compact('users','roles'));
    }

    /**
     * Store a newly created Lecturer in storage.
     *
     * @param CreateLecturerRequest $request
     *
     * @return Response
     */
    public function store(CreateLecturerRequest $request)
    {

        $user = User::find($request->user_id);
        $role = Role::find($request->role);

        foreach ($user->roles as $userRole) {
          if ($userRole->id == $request->role) {
            Flash::error('Role Sudah Ada');
            return redirect(route('lecturers.index'));
          }
        }

        $id = Lecturer::max('id') + 1;
        if ($role->role_code == 'RLDSN') {
          if ($user->lecturers == null) {
            Lecturer::insert([
              'id' => $id,
              'code' => $user->username,
              'jfa' => 'NJFA',
              'user_id' => $user->id
            ]);
          }
          $user->roles()->attach(Role::where('role_code','RLDSN')->first()->id);
          $user->roles()->attach(Role::where('role_code','RLPBB')->first()->id);
          $user->roles()->attach(Role::where('role_code','RLPGJ')->first()->id);
        }elseif ($role->role_code == 'RLSPR') {
          $user->roles()->attach($request->role);
          if( !$user->isAdmin() )
            $user->roles()->attach(Role::where('role_code','RLADM')->first()->id);
        }
        else{
          $user->roles()->attach($request->role);
        }

        Flash::success('Berhasil Menambahkan Role');

        return redirect(route('lecturers.index'));
    }

    /**
     * Display the specified Lecturer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            Flash::error('Lecturer Tidak Ada');

            return redirect(route('lecturers.index'));
        }

        return view('lecturers.show')->with('lecturer', $lecturer);
    }

    /**
     * Show the form for editing the specified Lecturer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lecturers = $this->lecturerRepository->all();
        $roles = Role::all();

        $lecturer = $this->lecturerRepository->find($id);
        if (empty($lecturer)) {
            Flash::error('Lecturer Tidak Ada');

            return redirect(route('lecturers.index'));
        }

        return view('lecturers.edit', compact('lecturers','lecturer','roles','users'));
    }

    /**
     * Update the specified Lecturer in storage.
     *
     * @param int $id
     * @param UpdateLecturerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLecturerRequest $request)
    {
        $lecturer = $this->lecturerRepository->find($id);

        if (empty($lecturer)) {
            Flash::error('Lecturer Tidak Ada');

            return redirect(route('lecturers.index'));
        }

        $lecturer = $this->lecturerRepository->update($request->all(), $id);

        Flash::success('Lecturer Berhasil Di ubah.');

        return redirect(route('lecturers.index'));
    }

    /**
     * Remove the specified Lecturer from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $role = Role::find($request->role);
        $user = User::find($request->id);
        if ($role->role_code == 'RLDSN') {
          $user->roles()->detach(Role::where('role_code','RLDSN')->first()->id);
          $user->roles()->detach(Role::where('role_code','RLPBB')->first()->id);
          $user->roles()->detach(Role::where('role_code','RLPGJ')->first()->id);
        }else{
          $user->roles()->detach($request->role);
        }

        Flash::success("Lecturer's Role Berhasil Di Hapus");

        return redirect(route('lecturers.index'));
    }
}
