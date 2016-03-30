<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitializeLogging extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        /**
         * Delete previous permissions.
         */
		DB::table('permissions')->whereIn('model', ['logs'])->delete();

		 /**
         * Insert the permissions related to this module.
         */
        DB::table('permissions')->insert(
        	[
        		/**
        		 * Logs model permissions.
        		 */
	        	[
	        	'name'       => 'find',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'search',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'list',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'findby',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'first',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginate',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginateby',
	        	'model'      => 'logs',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
        	]
        );

        /**
		 * Assign the permissions to the admin group.
		 */
		$permissionIds = DB::table('permissions')->whereIn('model', ['logs'])->select('id')->lists('id');
		$adminGroupId  = DB::table('groups')->where('name', 'Admin')->first()->id;
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

		DB::table('permissions')->whereIn('model', ['logs'])->delete();
		DB::table('users_groups')->where('user_id', $adminUserId)->where('group_id', $adminGroupId)->delete();
	}
}