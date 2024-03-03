<?php

namespace App\Http\Controllers\api;

use App\Models\Period;
use App\Models\Student;
use App\Models\Peminatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SidangController extends Controller
{
    public function index(){
        $students = Student::all();

        return [
            "success" => "200",
            "message" => "Berhasil fetching data",
            "data" => $students
        ];
    }

    public function detail (string $id){
        $user = Student::where("user_id", $id)->first();

        return [
             'succes' => "200",
                    "message" => "berhasil",
                    "data" => $user
        ];
    }
    
    public function store(Request $request, string $id){
        try{

            $request->validate([
                'peminatan_id' => 'required',
            ]);
            
            $test = Student::where('user_id',$id)->first();
            if($test){
                $test->update([
                    'peminatan_id' => $request->peminatan_id
                ]);
                return [
                    'succes' => "200",
                    "message" => "berhasil",
                    "data" => $test
                ];
            } else {
            return [
                'success' => false,
                'message' => 'Data student tidak ditemukan'
            ];
        }
        } catch (\Exception $e) {
            return [
                'success' => false,
        'message' => $e->getMessage()
            ];

        }
    }

    public function peminatans(Request $request){
        $request->validate([
            "kk" => 'required'
        ]);

        $peminatans = Peminatan::where("kk", $request->kk)->get();

        return[
        "status" => 200,
        "message" => "Berhasil",
        "data" => $peminatans
        ];
    }

    public function getAllPeriod(){
        $allPeriod = Period::getAllPeriod();

         return[
        "status" => 200,
        "message" => "Berhasil",
        "data" => $allPeriod
        ];
    }
}
