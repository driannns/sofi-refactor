<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Parameter;
use Flash;
use Response;
use Hash;
use DB;
use Log;
use Auth;

class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        if($filter == 'student')
            $users = User::with('students')->whereHas('students')->get();
        else if($filter == 'lecturer')
            $users = User::with('lecturers')->whereHas('lecturers')->get();
        else
            $users = $this->userRepository->all();

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {

        User::insert([
          'username' => $request->username,
          'nama' => $request->nama,
          'password' => Hash::make($request->password),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);

        Flash::success('Berhasil Ditambahkan');

        return redirect(route('users.index'));
    }

    public function addAdmin(CreateUserRequest $request)
    {

        $user = User::create([
          'username' => $request->username,
          'nama' => $request->nama,
          'password' => Hash::make($request->password),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);

        $user->roles()->attach(1);

        Flash::success('Berhasil Menambahkan Admin');
        return redirect(route('lecturers.index'));
    }


    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);
        $isDosen = false;
        if($user->lecturers()->count()){
          $isDosen = true;
          $child = $user->lecturers;
        }else if($user->students()->count()){
          $child = $user->students;
        }else{
          $child = null;
        }

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('users.show',compact('user', 'isDosen','child'));
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        $isDosen = false;
        if($user->lecturers()->count())
        {
            $isDosen = true;
            $child = $user->lecturers;
        }
        else if($user->students()->count())
            $child = $user->students;
        else
            $child = null;

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        // dd($child);

        return view('users.edit',compact('user','child','isDosen'));
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        $request->validate([
            'username' => 'unique:users,username,'.$id.',id',
        ]);

        $user = $this->userRepository->find($id);

        $isDosen = false;
        if($user->lecturers()->count())
        {
            $isDosen = true;
            $child = $user->lecturers;
        }
        else if($user->students()->count())
            $child = $user->students;
        else
            $child = null;

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        if(empty($request['password']))
            $request['password'] = $user->password;
        else
            $request['password'] = Hash::make($request->password);

        $user = $this->userRepository->update($request->all(), $id);
        if(!empty($child))
        {
            if($isDosen)
            {
                $lecturer = $user->lecturers;
                $lecturer['nip'] = $request['nip'];
                $lecturer['jfa'] = $request['jfa'];
                $lecturer['kk'] = $request['kk'];
                $lecturer->update();
            }else
            {
                $students = $user->students;
                $students->tak = $request['tak'];
                $students->eprt = $request['eprt'];
                $students->kk = $request['kk'];
                $students->update();
            }
        }

        Flash::success('User updated successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        if( $user->username == 'admin' )
        {
            Flash::error('User Admin tidak dapat dihapus');
            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('users.index'));
    }

    public function syncLecturer()
    {
        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $response = $client->request('GET', config('app.api.getAllLecturer'));
        $lecturers = json_decode($response->getBody());
        $err = array();
        $isNoNew = true;
        DB::beginTransaction();
        try
        {
            foreach ($lecturers->data as $lecturer) {
                if(Lecturer::where('code', $lecturer->lecturercode)->count() == 0)
                {
                    #Add new Data Lecturer
                    $isNoNew = false;
                    $resultInsertUser = User::updateOrCreate([
                        'username' => $lecturer->lecturercode,
                        'nama' => $lecturer->fullname,
                        'nipnim' => $lecturer->employeeid,
                        'password' => Hash::make('12345'),
                    ]);
                    //insert Role
                    if($resultInsertUser){
                        $roles = Role::whereIn('nama',['pembimbing','penguji','dosen'])->get();
                        foreach ($roles as $role) {
                            $resultInsertUser->roles()->attach($role->id);
                            Log::debug("berhasil insert");
                        }
                        $countLecturers = Lecturer::count();
                        $set_id = $countLecturers+1;
                        $resultInsertLecturer = Lecturer::insert([
                            'id' => $set_id,
                            'nip' => $lecturer->employeeid,
                            'code' => $lecturer->lecturercode,
                            'jfa' => $lecturer->jfa,
                            'kk'=> $lecturer->skillgroupname,
                            'user_id' => $resultInsertUser->id
                        ]);
                    }
                    else
                    {
                        $err[] = "data ".$lecturer->fullname." gagal insert";
                    }
                }else{
                    #Sync all data lecturer

                    $lecturerData = Lecturer::where('code', $lecturer->lecturercode)->first();
                    $lecturerData->nip = $lecturer->employeeid;
                    $lecturerData->code = $lecturer->lecturercode;
                    $lecturerData->jfa = $lecturer->jfa;
                    $lecturerData->kk = $lecturer->skillgroupname;
                    $lecturerData->update();
                }
            }
            if($isNoNew)
            {
                DB::commit();
                Flash::success("data dosen berhasil sync dan tidak ada data dosen baru yang ditambah");
                return redirect(route('users.index'));
            }
            if(count($err) > 0)
            {
                DB::rollback();
                $err[] = "Silahkan lakukan ulang import data yang benar";
                Flash::error('error',$err);
            }
            if(empty($err))
            {
                DB::commit();
                Flash::success('success',"data dosen berhasil sync dan telah di tambahkan akun dosen baru");
                return redirect(route('users.index'));
            }
        } catch (\Exception $e){
            Log::error($e);
            DB::rollback();
        }
    }

    public function syncStudents()
    {
        $client = new \GuzzleHttp\Client(['verify' => false ]);
        $parameter = Parameter::find('periodAcademic');

        $response = $client->request('GET', config('app.api.getAllStudents').'/'.$parameter->value);
        $students = json_decode($response->getBody());
        $response = $client->request('GET', config('app.api.getDataTA').$parameter->value);
        $dataTA = json_decode($response->getBody());
        $err = array();
        DB::beginTransaction();
        try
        {
            foreach ($students->data as $student) {
                #Sync all data lecturer
                $student_selected = Student::where('nim', $student->studentid)->first();
                if(!empty($student_selected)){
                    foreach ($dataTA->data as $ta) {
                        if($ta->studentid == $student_selected->nim){
                            $student_selected->nim = $student->studentid;
                            $student_selected->tak = $student->tak;
                            $student_selected->eprt = $student->eprt;
                            $student_selected->kk = $ta->skillgroupname;
                            $student_selected->user->nama = $student->fullname;
                            $student_selected->study_program = $student->studyprogramname;
                            $student_selected->user->update();
                            $student_selected->update();
                            break;
                        }
                    }
                }
            }
            if(empty($err))
            {
                DB::commit();
                Flash::success('success',"data mahasiswa berhasil sync");
                return redirect(route('users.index'));
            }
        } catch (\Exception $e){
            Log::error($e);
            DB::rollback();
        }
    }
}
