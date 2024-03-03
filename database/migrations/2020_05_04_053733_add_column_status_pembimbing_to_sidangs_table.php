<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusPembimbingToSidangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->string('status_pembimbing1')->nullable();
            $table->string('status_pembimbing2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sidangs', function (Blueprint $table) {
            $table->dropColumn('status_pembimbing1');
            $table->dropColumn('status_pembimbing2');
        });
    }
}
