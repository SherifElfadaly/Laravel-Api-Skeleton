<?php

use Illuminate\Database\Seeder;

class ClearDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$adminGroupId = DB::table('groups')->where('name', 'Admin')->first()->id;
    	$adminUserId  = DB::table('users')->where('email', 'admin@user.com')->first()->id;
    	$permissions  = DB::table('permissions')->whereIn('model', ['users', 'permissions', 'groups']);

    	DB::table('groups_permissions')->whereIn('permission_id', $permissions->pluck('id'))->delete();
    	DB::table('users_groups')->where('user_id', $adminUserId)->where('group_id', $adminGroupId)->delete();

    	DB::table('users')->where('email', 'admin@user.com')->delete();
    	DB::table('groups')->where('name', 'Admin')->delete();
    	
    	$permissions->delete();
    }
}
