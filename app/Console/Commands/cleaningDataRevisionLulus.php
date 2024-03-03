<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule as scheduleModel;
use App\Http\Controllers\StatusLogController;
use App\Http\Controllers\AppBaseController;

class cleaningDataRevisionLulus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cleaningDataRevisionLulus';

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
            $schedules = scheduleModel::whereHas('revisions', function($query){
                        $query->whereIn('status',['sudah dikirim']);
                      })
                      ->where('status','<>', 'belum dilaksanakan')
                      ->where('status','<>', 'sedang dilaksanakan')
                      ->whereHas('sidang', function($query){
                        $query->whereIn('status', ['lulus']);
                      })->get();
            foreach ($schedules as $schedule) {
                if(count($schedule->revisions) > 0){
                    foreach ($schedule->revisions as $revision) {
                        $revision->update(['status' => 'disetujui']);
                        StatusLogController::addStatusLog(
                            $revision->schedule->sidang->id,
                            "-",
                            'revisi',
                            'disetujui by system'
                          );
                    }
                }
            }
        }catch (exception $e) {
           Log::error("Error cleaningDataRevisionLulus: ".$e);
        }
    }
}
