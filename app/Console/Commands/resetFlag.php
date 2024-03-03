<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule as scheduleModel;

class resetFlag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:resetFlag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            scheduleModel::where('flag_add_revision','=','1')->orWhere('flag_change_scores','=','1')
                    ->update([
                        'flag_add_revision' => 0,
                        'flag_change_scores' => 0
                    ]);
        }catch (exception $e) {
           Log::error("Error reset Flag: ",$e);
        }
    }
}
