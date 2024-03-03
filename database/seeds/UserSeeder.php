<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = DB::table('users')->get();

    	if($users == '[]')
    	{
	    	//DOSEN
	        DB::table('users')->insert([
	            'username' => 'aaa',
	            'nama' => 'dosen_a',
	            'password' => Hash::make('kud4kambing'),
	        ]);

	        DB::table('users')->insert([
	            'username' => 'bbb',
	            'nama' => 'dosen_b',
	            'password' => Hash::make('kud4kambing'),
	        ]);

          DB::table('users')->insert([
	            'username' => 'ccc',
	            'nama' => 'dosen_c',
	            'password' => Hash::make('kud4kambing'),
	        ]);

	        DB::table('users')->insert([
	            'username' => 'ddd',
	            'nama' => 'dosen_d',
	            'password' => Hash::make('kud4kambing'),
	        ]);

          DB::table('users')->insert([
	            'username' => 'eee',
	            'nama' => 'dosen_e',
	            'password' => Hash::make('kud4kambing'),
	        ]);

	        DB::table('users')->insert([
	            'username' => 'fff',
	            'nama' => 'dosen_f',
	            'password' => Hash::make('kud4kambing'),
	        ]);

	        //ADMIN
	        DB::table('users')->insert([
	            'username' => 'admin',
	            'nama' => 'admin',
	            'password' => Hash::make('kud4kambing'),
	        ]);
    	}
    }
}
