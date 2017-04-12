<?php

use Illuminate\Database\Seeder;

class AssignRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        /**
		 * Assign the permissions to the admin group.
		 */
    	$adminGroupId = DB::table('groups')->whereIn('name', 'admin')->select('id')->first()->id;
        DB::table('permissions')->whereIn('model', ['settings', 'logs'])->each(function ($permission) use ($adminGroupId) {
        	DB::table('groups_permissions')->insert(
				[
				'permission_id' => $permission->id,
				'group_id'      => $adminGroupId,
				'created_at'    => \DB::raw('NOW()'),
				'updated_at'    => \DB::raw('NOW()')
				]
			);
        });
    }
}
