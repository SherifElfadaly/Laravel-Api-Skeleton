<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitializeAcl extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
         * Insert the permissions related to this module.
         */
        DB::table('permissions')->insert(
        	[
        		/**
        		 * Users model permissions.
        		 */
	        	[
	        	'name'       => 'save',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'delete',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'find',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'list',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'search',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'findby',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'first',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginate',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginateby',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'assigngroups',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'block',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'unblock',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'group',
	        	'model'      => 'users',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
                [
                'name'       => 'deleted',
                'model'      => 'users',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'restore',
                'model'      => 'users',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],

	        	/**
        		 * Permissions model permissions.
        		 */
        		[
	        	'name'       => 'find',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'search',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'list',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'findby',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'first',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginate',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginateby',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],

	        	/**
        		 * Groups model permissions.
        		 */
	        	[
	        	'name'       => 'save',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'delete',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'find',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'search',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'list',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'findby',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'first',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginate',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginateby',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'assignpermissions',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'users',
	        	'model'      => 'groups',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
                [
                'name'       => 'deleted',
                'model'      => 'users',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'restore',
                'model'      => 'users',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
        	]
        );

		/**
		 * Create Default groups.
		 */
		$adminGroupId = DB::table('groups')->insertGetId(
			[
			'name'       => 'Admin',
			'created_at' => \DB::raw('NOW()'),
			'updated_at' => \DB::raw('NOW()')
			]
		);

		/**
		 * Create Default users.
		 */
		$adminUserId = DB::table('users')->insertGetId(
            [
			'email'      => 'admin@user.com',
			'password'   => bcrypt('123456'),
			'created_at' => \DB::raw('NOW()'),
			'updated_at' => \DB::raw('NOW()')
			]
        );

		/**
		 * Assign users to groups.
		 */
		DB::table('users_groups')->insert(
        	[
	            [
				'user_id'    => $adminUserId,
				'group_id'   => $adminGroupId,
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
	            ]
        	]
        );

        /**
		 * Assign the permissions to the admin group.
		 */
		$permissionIds = DB::table('permissions')->whereIn('model', ['users', 'permissions', 'groups'])->select('id')->pluck('id');
		foreach ($permissionIds as $permissionId) 
		{
			DB::table('groups_permissions')->insert(
				[
				'permission_id' => $permissionId,
				'group_id'      => $adminGroupId,
				'created_at'    => \DB::raw('NOW()'),
				'updated_at'    => \DB::raw('NOW()')
				]
			);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$adminGroupId = DB::table('groups')->where('name', 'Admin')->first()->id;
		$adminUserId  = DB::table('users')->where('email', 'admin@user.com')->first()->id;
		$permissions  = DB::table('permissions')->whereIn('model', ['users', 'permissions', 'groups']);

		DB::table('groups_permissions')->whereIn('permission_id', $permissions->pluck('id'))->delete();
		DB::table('users_groups')->where('user_id', $adminUserId)->where('group_id', $adminGroupId)->delete();
		
		$permissions->delete();
		DB::table('users')->where('email', 'admin@user.com')->delete();
		DB::table('groups')->where('name', 'Admin')->delete();
	}
}