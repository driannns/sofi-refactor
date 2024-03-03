<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSidangsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sidangs', function(Blueprint $table){
          $table->integer('credit_complete')->nullable();
          $table->integer('credit_uncomplete')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('sidangs', function(Blueprint $table){
        $table->dropColumn('credit_complete');
        $table->dropColumn('credit_uncomplete');
      });
    }
}
