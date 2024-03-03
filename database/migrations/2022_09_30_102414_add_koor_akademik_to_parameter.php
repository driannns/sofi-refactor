<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Parameter;

class AddKoorAkademikToParameter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('parameters')->insert(
            array(
                'id' => 'koor_akademik',
                'name' => 'Ka.Urusan Akademik',
                'value' => 'Edi Sutoyo, S.Kom., M.CompSc.',
                'created_at' => DB::raw('CURRENT_TIMESTAMP'),
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Parameter::where('id','koor_akademik')->delete();
    }
}
