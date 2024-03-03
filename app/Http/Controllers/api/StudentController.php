<?php

namespace App\Http\Controllers\api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function detail($id){
        try{

            $student = Student::where("user_id", $id)->first();
            return[
                "status" => 200,
                "message" => "Success",
                "data" => $student
            ];
        } catch(\Exception $e){
            return[
                "status" => 400,
                "message" => "Success",
                "data" => "Error when fetching data: $e"
            ];

        }
    }
}
