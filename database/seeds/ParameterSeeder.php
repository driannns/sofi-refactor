<?php

use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parameters')->insert([
            'id' => 'periodAcademic',
            'name' => 'Periode Akademik Aktif',
            'value' => '1920-1',
        ]);
    }
}
