<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;


class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relation = DB::table('user_has_role')->get();
    	if($relation == '[]')
    	{
	    	$admin = User::where('username','admin')->first()->id;
	    	$roleAdmin = Role::where('role_code','RLADM')->first()->id;
	        DB::table('user_has_role')->insert([
	        	'user_id' => $admin,
	            'role_id' => $roleAdmin,
	        ]);
	    }
    }
}
