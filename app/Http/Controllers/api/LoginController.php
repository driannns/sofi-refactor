<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request){
        try {
            $request->validate([
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]);
            $roles =[];
            $user = User::where('username', $request->username)->with("roles")->firstOrFail();
            
            foreach($user->roles as $role){
                $roles[] = $role->role_code;
            }
            $userStudent = $user->students;
            if($userStudent){
                $userStudent = $user->students->nim;
            }
            
            $userLecturer = $user->lecturers;
            if($userLecturer){
                $userLecturer = $user->lecturers->nip;
            }
            $payload = [
				"id" => $user->id,
				"username" => $user->username,
				"nama" => $user->nama,
				"nim" => $userStudent,
				"nip" => $userLecturer,
				// "role" => $user->roles[0]->role_code
				"role" => $roles
			];
            $key = "secret";
            $jwt = JWT::encode($payload, $key, 'HS256');
            Session::put('authToken', $jwt);

            // auth()->login($userOnly, true);
            
           return [
                "status" => 200,
                "message" => "Success",
                // "data" => $user,
                "token" => Session::get('authToken')
            ];
        }
        catch (\Exception $e) {
            return [
                "status" => 401,
                "message" => "The credentials do not match our records: $e",
                "data" => [],
            ];
        }
    }
}
