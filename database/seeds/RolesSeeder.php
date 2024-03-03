<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = DB::table('roles')->get();

        if ($roles == '[]') {
          DB::table('roles')->insert([
            'nama' => 'admin',
            'role_code' => 'RLADM',
          ]);

          DB::table('roles')->insert([
            'nama' => 'PIC TA',
            'role_code' => 'RLPIC',
          ]);

          DB::table('roles')->insert([
            'nama' => 'mahasiswa',
            'role_code' => 'RLMHS',
          ]);

          DB::table('roles')->insert([
            'nama' => 'pembimbing',
            'role_code' => 'RLPBB',
          ]);

          DB::table('roles')->insert([
            'nama' => 'penguji',
            'role_code' => 'RLPGJ',
          ]);

          DB::table('roles')->insert([
            'nama' => 'dosen',
            'role_code' => 'RLDSN',
          ]);

          DB::table('roles')->insert([
            'nama' => 'superadmin',
            'role_code' => 'RLSPR',
          ]);
        }

    }
}
