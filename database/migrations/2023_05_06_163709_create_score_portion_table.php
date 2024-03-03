<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScorePortionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_portions', function (Blueprint $table) {
            $table->id();
            $table->integer('period_id');
            $table->unsignedBigInteger('study_program_id');
            $table->float('pembimbing');
            $table->float('penguji');
            $table->timestamps();

            $table->foreign('period_id')
                ->references('id')
                ->on('periods')
                ->onDelete('restrict');
            $table->foreign('study_program_id')
                ->references('id')
                ->on('study_programs')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_portions');
    }
}
