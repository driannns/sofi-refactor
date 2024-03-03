<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Models\Role;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Parameter;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'nama' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        // insert role and user pivot table from created user
        $user_id = User::where('username', $data['username'])->get();
        $role_id = Role::where('nama', 'mahasiswa')->get();

        $user->roles()->attach($role_id[0]->id);

        $client = new \GuzzleHttp\Client(['verify' => false ]);
        $response = $client->request('GET', config('app.api.getDataTA').$data['username']);
        $dataTA = json_decode($response->getBody());

        //insert student table
        Student::create([
          'nim' => $data['username'],
          'user_id' => $user_id[0]->id,
          'tak' => $data['tak'],
          'eprt' => $data['eprt'],
          'kk' => $dataTA->data[0]->skillgroupname,
          'team_id' => 0
        ]);

        return $user;
    }

    protected function showRegistrationForm(){
      $client = new \GuzzleHttp\Client(['verify' => false ]);
      // $response = $client->request('GET', 'https://my-json-server.typicode.com/ekkynovrizalam/api_json/students');

      $parameter = Parameter::find('periodAcademic');
      $response = $client->request('GET', config('app.api.getAllStudents').'/'.$parameter->value);
      $students = json_decode($response->getBody());

      return view('auth.register', ['students' => $students->data]);
    }

    static function registerUserSSO($username,$token)
    {
        $client = new \GuzzleHttp\Client(['verify' => false ]);
        $header = [
            'headers' => [
                "Authorization" => "Bearer ".$token
            ]
        ];
        $getProfileResponse = $client->request('GET', config('app.api.getProfileSSO'), $header);
        $userProfile = json_decode($getProfileResponse->getBody());

        try {
            //check if user is old user
            $cekUserOldExist = User::where('nipnim',$userProfile->data[0]->nipnim)->firstOrFail();
            // dd($userProfile);
            if( $cekUserOldExist->username != $username )
            {
                //update data user with sso profile
                $cekUserOldExist->username = $username;
                $cekUserOldExist->password = "invalid";
                $cekUserOldExist->email_verified_at = now();
                $cekUserOldExist->update();

                return $cekUserOldExist;
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            //if user is not old user
            $user = User::create([
                'nama' => $userProfile->data[0]->fullname,
                'username' => $username,
                'password' => "invalid",
		'nipnim' => $userProfile->data[0]->nipnim,
                'email_verified_at' => now()
            ]);

            //check role user
            if($userProfile->data[0]->groupname == "STAFF")
            {
                if($userProfile->data[0]->lecturercode != null){
                    $response = $client->request('GET', config('app.api.getAllLecturer').$userProfile->data[0]->nipnim);
                    $dataLecturer = json_decode($response->getBody());
                    $roles = Role::whereIn('nama',['pembimbing','penguji','dosen'])->get();
                    foreach ($roles as $role) {
                        $user->roles()->attach($role->id);
                        Log::debug("berhasil insert");
                    }
                    $countLecturers = Lecturer::count();
                    $resultInsertLecturer = Lecturer::insert([
                        'id' => $countLecturers+1,
                        'nip' => $dataLecturer->employeeid,
                        'code' => $dataLecturer->lecturercode,
                        'jfa' => $dataLecturer->jfa,
                        'kk'=> $dataLecturer->skillgroupname,
                        'user_id' => $user->id
                    ]);
                    return $user;
                }else{
                    //tpa must config role manual via app
                    return $user;
                }
            }elseif ($userProfile->data[0]->groupname == "STUDENT") {
                // insert role and user pivot table from created user
                // $user_id = User::where('username', $data['username'])->get();
                $role_id = Role::where('nama', 'mahasiswa')->get();

                $user->roles()->attach($role_id[0]->id);

                $client = new \GuzzleHttp\Client(['verify' => false ]);
                $parameter = Parameter::find('periodAcademic');
                $response = $client->request('GET', config('app.api.getDataTA').$parameter->value."/".$userProfile->data[0]->nipnim);
                $dataTA = json_decode($response->getBody());
                $response = $client->request('GET', config('app.api.getStudent').$parameter->value."/".$userProfile->data[0]->nipnim);
                $dataStudent = json_decode($response->getBody());

                if(count($dataStudent->data)>0)
                {
                    //insert student table
                    Student::create([
                    'nim' => $userProfile->data[0]->nipnim,
                    'user_id' => $user->id,
                    'tak' => $dataStudent->data[0]->tak,
                    'eprt' => $dataStudent->data[0]->eprt,
                    'kk' => $dataTA->data[0]->skillgroupname,
                    'team_id' => 0
                    ]);

                    return $user;
                }else{
                    $user->roles()->detach();
                    $user->delete();
                    return false;
                }
            }
            
        }catch (\Exception $e) {
            // print_r($e);
            return false;
        }
        
        
        

        
    }


}
