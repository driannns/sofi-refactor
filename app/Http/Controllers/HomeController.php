<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Auth;
use App\User;
use App\Models\Student;
use App\Models\Sidang;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = null;
        $revisions = null;
        $schedulesNotComplete = null;
        $statussidang = null;
        $periode = null;
        $no_laa = Parameter::where('id','nomor_laa')->first()->value;
        $kaur_akademik = Parameter::where('id','koor_akademik')->first()->value;
        if( Auth::user()->isStudent() )
        {
        $status = User::with('student')->where('id','=',Auth::user()->id)->first();
        $statussidang = Sidang::with('mahasiswa')->where('Mahasiswa_id','=',$status->student->nim)->first();
        $periode = sidang::with('period')->where('Mahasiswa_id','=',$status->student->nim)->first();
        }

        if( Auth::user()->isDosen() )
        {
            $schedules[] = Schedule::where('status','<>', 'belum dilaksanakan')
                                    ->where('penguji1','=',Auth::user()->lecturer->id)
                                    ->doesntHave('scores')
                                    ->get();
            $schedules[] = Schedule::where('status','<>', 'belum dilaksanakan')
                                    ->where('penguji2','=',Auth::user()->lecturer->id)
                                    ->doesntHave('scores')
                                    ->get();
            $schedules[] = Schedule::where('status','<>', 'belum dilaksanakan')
                                            ->whereHas('sidang', function ($query) {
                                                    $query->where('pembimbing1_id', '=', Auth::user()->lecturer->id);
                                                })
                                            ->doesntHave('scores')
                                            ->get();
            $schedules[] = Schedule::where('status','<>', 'belum dilaksanakan')
                                            ->whereHas('sidang', function ($query) {
                                                    $query->where('pembimbing2_id', '=', Auth::user()->lecturer->id);
                                                })
                                            ->doesntHave('scores')
                                            ->get();

            $revisions[] = Schedule::where('penguji1','=',Auth::user()->lecturer->id)
                                        ->whereHas('revisions', function ($query) {
                                            $query->where('status','=','sudah dikirim')
                                            ->where('lecturer_id','=',Auth::user()->lecturer->id);
                                        })
                                        ->get();

            $revisions[] = Schedule::where('penguji2','=',Auth::user()->lecturer->id)
                                        ->whereHas('revisions', function ($query) {
                                            $query->where('status','=','sudah dikirim')
                                            ->where('lecturer_id','=',Auth::user()->lecturer->id);
                                        })
                                        ->get();

            $schedulesNotComplete[] = Schedule::where('status','=', 'sedang dilaksanakan')
                                    ->where('penguji1','=',Auth::user()->lecturer->id)
                                    ->where('date','!=',now())
                                    ->get();

        }

        return view('home',compact('periode','statussidang','schedules','revisions','schedulesNotComplete','no_laa','kaur_akademik'));
    }
}
