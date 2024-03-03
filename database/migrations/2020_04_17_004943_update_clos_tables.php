<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::table('intervals', function (Blueprint $table) {
          $table->dropForeign('fk_intervals_components1');
          $table->integer('id',11)->autoIncrement()->change();
      });

      Schema::table('scores', function (Blueprint $table) {
          $table->dropForeign('fk_scores_components1');
          $table->integer('id',11)->autoIncrement()->change();
      });

      Schema::table('components', function (Blueprint $table) {
          $table->dropForeign('fk_components_clos1');
          $table->integer('id',11)->autoIncrement()->change();
      });

      Schema::table('clos', function (Blueprint $table) {
          $table->dropForeign('fk_clos_periods1');
          $table->integer('id',11)->autoIncrement()->change();
      });

      // rearrange fk constraion
      Schema::table('intervals', function (Blueprint $table) {
          $table->foreign('component_id','fk_intervals_components1')
          ->references('id')
          ->on('components')
          ->onDelete('restrict');
      });

      Schema::table('scores', function (Blueprint $table) {
          $table->foreign('component_id','fk_scores_components1')
          ->references('id')
          ->on('components')
          ->onDelete('restrict');
      });

      Schema::table('components', function (Blueprint $table) {
          $table->foreign('clo_id','fk_components_clos1')
          ->references('id')
          ->on('clos')
          ->onDelete('restrict');
      });

      Schema::table('clos', function (Blueprint $table) {
          $table->foreign('period_id','fk_clos_periods1')
          ->references('id')
          ->on('periods')
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
        //
    }
}
