<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('revision_id');
            $table->text('feedback');
            $table->timestamps();

            $table->foreign('revision_id')
            ->references('id')
            ->on('revisions')
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
        Schema::dropIfExists('revision_logs');
    }
}
