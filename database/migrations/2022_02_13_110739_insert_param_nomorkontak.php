<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertParamNomorkontak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $models = array(
            array(
                'id' => 'nomor_laa',
                'name' => 'Nomor LAA',
                'value' => '+6281311997199',
                )
        );

        \Illuminate\Support\Facades\DB::table('parameters')->insert($models);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Parameter::where('id', 'nomor_laa')->first()->delete();
    }
}
