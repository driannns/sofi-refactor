<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use Log;

class cekData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cek-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Untuk Cek API yang mau di tembak';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    function ldap($username, $password)
    {
        // $post = [
        //     'username' => $username,
        //     'password' => $password
        // ];
        // $config['useragent'] = request()->header('User-Agent');
        $config['useragent'] = "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0";
        Log::info($config['useragent']);


        $ch = curl_init('https://dev-gateway.telkomuniversity.ac.id/0f5efc75bbfe9f82c255d0bca87c6d69/MHY');
        curl_setopt($ch, CURLOPT_USERAGENT, $config['useragent']);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = '';
        $password ='';

        $api = $this->ldap($user,$password);

        Log::info($api);
    }
}
