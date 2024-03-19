<?php

namespace App\Http\Controllers\api;

use App\Models\Student;
use App\Models\Lecturer;
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
                "message" => "Error",
                "data" => "Error when fetching data: $e"
            ];

        }
    }

    public function update(Request $request, $id){
        try{
            $request->validate([
                "team_id" => 'required|string'
            ]);

            $student = Student::where("user_id", $id)->first();
            
            $student->update([
                "team_id" => $request->team_id
            ]);

              return[
                "status" => 200,
                "message" => "Success update data student",
                "data" => $student
            ];
        }
        catch(\Exception $e){
            return[
                  
                "status" => 400,
                "message" => "Error",
                "data" => "Error when fetching data: $e"
            ];
        }
    }

    public function getLecturer(){
        $lecturers = Lecturer::with('user')->orderBy('code')->get();

        return [
            "status" => 200,
            "message" => "Success",
            "data" => $lecturers
        ];
    }
}
