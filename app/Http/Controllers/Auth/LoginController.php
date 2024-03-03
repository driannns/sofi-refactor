<?php

namespace App\Http\Controllers\Auth;

use Log;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Parameter;
use PhpParser\Node\Param;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function loginSSOTelU()
    {
        $no_laa = Parameter::where('id','nomor_laa')->first()->value;
        return view('auth.loginSSOTelU',compact('no_laa'));
    }

    public function checkloginSSOTelU(Request $request)
    {
        $no_laa = Parameter::where('id','nomor_laa')->first()->value;
        try {
            $request->validate([
                'username' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]);
            $user = User::where('username', $request->username)->firstOrFail();
       
            auth()->login($user, true);
            return redirect($this->redirectPath());
        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            dd($e);
            //if user not exist
            $resultRegist = RegisterController::registerUserSSO($username,$userLoged->token);
            if(!$resultRegist){
                return redirect()->route('loginSSO',compact('no_laa'))->withErrors(['username' => 'Data tidak ditemukan']);
            }else{
                auth()->login($resultRegist, true);
                activity()
                    ->causedBy(Auth::user())
                    ->log('login_new_user');
                return redirect($this->redirectPath());
            }
        }
        catch (\Exception $e) {
            dd($e);
            // dd($response);
            activity()
                ->causedBy(Auth::user())
                ->log('login:error');
            return redirect()->route('loginSSO',compact('no_laa'))->withErrors(['username' => 'The credentials do not match our records']);
        }
    }
}
