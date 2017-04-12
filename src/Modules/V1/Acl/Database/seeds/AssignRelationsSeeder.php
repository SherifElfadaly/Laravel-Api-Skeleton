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
    	$adminGroupId = DB::table('groups')->whereIn('name', 'admin')->select('id')->first()->id;
		$adminUserId  = DB::table('users')->whereIn('email', 'admin@user.com')->select('id')->first()->id;

		/**
		 * Assign users to groups.
		 */
		DB::table('users_groups')->insert(
			[
			'user_id'    => $adminUserId,
			'group_id'   => $adminGroupId,
			'created_at' => \DB::raw('NOW()'),
			'updated_at' => \DB::raw('NOW()')
			]
        );

        /**
		 * Assign the permissions to the admin group.
		 */
        DB::table('permissions')->whereIn('model', ['users', 'permissions', 'groups'])->each(function ($permission) use ($adminGroupId) {
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
