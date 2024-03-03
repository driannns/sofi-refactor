<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $teams = DB::table('teams')->get();

      if ($teams == '[]') {

        DB::table('teams')->insert([
          'id' => 0,
          'name' => 'Belum Memiliki Team',
        ]);
      }
    }
}
