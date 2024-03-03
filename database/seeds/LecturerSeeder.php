<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$lecturer = DB::table('lecturers')->get();
    	if($lecturer == '[]')
    	{
	    	$aaa = User::where('username','aaa')->first()->id;
	        DB::table('lecturers')->insert([
	        	'id' => 1,
	            'nip' => '20920013',
	            'code' => 'aaa',
	            'jfa' => '',
	            'kk' => '',
	            'user_id' => $aaa
	        ]);

	        $bbb = User::where('username','bbb')->first()->id;
	        DB::table('lecturers')->insert([
	            'id' => 2,
	            'nip' => '209200001',
	            'code' => 'bbb',
	            'jfa' => '',
	            'kk' => '',
	            'user_id' => $bbb
	        ]);

        $aaa = User::where('username','ccc')->first()->id;
	        DB::table('lecturers')->insert([
	        	'id' => 3,
	            'nip' => '2092230013',
	            'code' => 'ccc',
	            'jfa' => '',
	            'kk' => '',
	            'user_id' => $aaa
	        ]);

	        $bbb = User::where('username','ddd')->first()->id;
	        DB::table('lecturers')->insert([
	            'id' => 4,
	            'nip' => '2092030001',
	            'code' => 'ddd',
	            'jfa' => '',
	            'kk' => '',
	            'user_id' => $bbb
	        ]);

          $aaa = User::where('username','eee')->first()->id;
  	        DB::table('lecturers')->insert([
  	        	'id' => 5,
  	            'nip' => '209200131',
  	            'code' => 'eee',
  	            'jfa' => '',
  	            'kk' => '',
  	            'user_id' => $aaa
  	        ]);

  	        $bbb = User::where('username','fff')->first()->id;
  	        DB::table('lecturers')->insert([
  	            'id' => 6,
  	            'nip' => '2092000012',
  	            'code' => 'fff',
  	            'jfa' => '',
  	            'kk' => '',
  	            'user_id' => $bbb
  	        ]);

  	        $bbb = User::where('username','admin')->first()->id;
  	        DB::table('lecturers')->insert([
  	            'id' => 7,
  	            'nip' => '0000000000',
  	            'code' => 'XXX',
  	            'jfa' => '',
  	            'kk' => '',
  	            'user_id' => $bbb
  	        ]);
	    }
    }
}
