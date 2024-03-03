<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Auth;
use App\User;
use App\Models\Lecturer;
use App\Models\Student;
use App\Notifications\DocumentNotification;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function sendNotification($username,$title,$message,$url)
    {
        //username yg di terima merupakan username versi lama (non SSO) -> nim/code dosen
        //if user admin non dosen
        $isUserOnly = true;
        $user = User::where('username',$username)->first();
        if(empty($user)){
            $user = Lecturer::where('code',$username)->first();
            $isUserOnly = false;
        }
        if(empty($user)){
            $user = Student::where('nim',$username)->first();
            $isUserOnly = false;
        }
        if(empty($user)){
            Log::error('User empty dan tidak di temukan. Username:',$username);
            return false;
        }

        if(Auth::user() == null){
            $user_id = User::where('username','admin')->first()->id;
        }else
            $user_id = Auth::user()->id;

        $details = [
            'title' => $title,
            'message' => $message,
            'actionURL' => url($url),
            'created_by' => $user_id
        ];

        if (!$isUserOnly) {
          $user = $user->user;
        }

        $user->notify(new DocumentNotification($details));
    }
}
