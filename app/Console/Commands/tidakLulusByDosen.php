<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule as scheduleModel;
use App\Models\Sidang as sidangModel;
use App\Models\Team;
use App\Models\Student;
use App\Http\Controllers\StatusLogController;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;

class tidakLulusByDosen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:tidakLulusByDosen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $appBase;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AppBaseController $appBase)
    {
        parent::__construct();
        $this->appBase = $appBase;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            //reset to tidak lulus jika revisi lewat waktu akibat dosen tidak melakukan approve
            $schedules = scheduleModel::whereHas('revisions', function($query){
                            $query->whereIn('status',['sudah dikirim']);
                          })
                          ->where('status','<>', 'belum dilaksanakan')
                          ->where('status','<>', 'sedang dilaksanakan')
                          ->whereHas('sidang', function($query){
                            $query->whereNotIn('status', ['sidang ulang','lulus','tidak lulus']);
                          })->get();
            foreach ($schedules as $schedule) {
                if( $schedule->durasi_revisi == 7 )
                {
                    if( Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) < now() )
                    {
                        $schedule->sidang->update(['status' => 'tidak lulus']);
                        $schedule->update(['keputusan' => 'tidak lulus']);
                        StatusLogController::addStatusLog($schedule->sidang->id,"-","tidak lulus","tidak lulus");
                        $this->appBase->sendNotification(
                        $schedule->sidang->mahasiswa->user->username,
                            "Tidak Lulus",
                            "Mohon maaf anda dinyatakan tidak lulus, karena revisi anda tidak selesai sesuai waktu yang ditentukan",
                            "sidangs/create"
                        );
                        $this->notifToAllAdmin($schedule);
                        $this->resetTeam($schedule->sidang);
                    }
                }elseif( $schedule->durasi_revisi == 14 ){
                    if( Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +7 ) < now() )
                    {
                        $schedule->sidang->update(['status' => 'tidak lulus']);
                        $schedule->update(['keputusan' => 'tidak lulus']);
                        StatusLogController::addStatusLog($schedule->sidang->id,"-","tidak lulus","tidak lulus");
                        $this->appBase->sendNotification(
                        $schedule->sidang->mahasiswa->user->username,
                            "Tidak Lulus",
                            "Mohon maaf anda dinyatakan tidak lulus, karena revisi anda tidak selesai sesuai waktu yang ditentukan",
                            "sidangs/create"
                        );
                        $this->notifToAllAdmin($schedule);
                        $this->resetTeam($schedule->sidang);
                    }
                }else{
                    if( Carbon::parse($schedule->date)->addDays( (int)$schedule->durasi_revisi +21 ) < now() )
                    {
                        $schedule->sidang->update(['status' => 'tidak lulus']);
                        $schedule->update(['keputusan' => 'tidak lulus']);
                        StatusLogController::addStatusLog($schedule->sidang->id,"-","tidak lulus","tidak lulus");
                        $this->appBase->sendNotification(
                        $schedule->sidang->mahasiswa->user->username,
                            "Tidak Lulus",
                            "Mohon maaf anda dinyatakan tidak lulus, karena revisi anda tidak selesai sesuai waktu yang ditentukan",
                            "sidangs/create"
                        );
                        $this->notifToAllAdmin($schedule);
                        $this->resetTeam($schedule->sidang);
                    }
                }
            }
        }catch (exception $e) {
           Log::error("Error tidakLulusByDosen: ".$e);
        }
    }

    public function notifToAllAdmin($schedule)
    {
        //status by pass ke admin
        $input['status'] = 'Tidak Lulus By Sistem';
        //Notif
        $title = "Mahasiswa tidak lulus by sistem";
        $message = "Mahasiswa dengan nim ".$schedule->sidang->mahasiswa->nim." dinyatakan tidak lulus karena dosen penguji tidak melakukan approve revisi sesuai waktu yang sudah ditentukan";
        $url = "/sidangs";

        foreach (\App\Models\User::getAdmin() as $admin)
        {
            $this->appBase->sendNotification($admin->username,$title,$message,$url);
        }
    }

    private function resetTeam($sidang)
    {
      $team_id = $sidang->mahasiswa->team_id;
      $count = Student::where('team_id', $team_id)
              ->count();
      Student::where('nim', $sidang->mahasiswa_id)->update([
          'team_id' => 0,
      ]);
      if ($count <= 1) {
          Team::where('id', $team_id)
          ->delete();
      }
    }
}
