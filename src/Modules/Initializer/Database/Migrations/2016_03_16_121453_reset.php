<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reset extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Reset all tables.
		 */
		DB::table('users')->truncate();
		DB::table('groups')->truncate();
		DB::table('permissions')->truncate();
		DB::table('groups_permissions')->truncate();
		DB::table('users_groups')->truncate();
		DB::table('settings')->truncate();

		/**
		 * Create Default groups.
		 */
		DB::table('groups')->insert(
			[
				[
				'name'       => 'Admin',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				]
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
		$adminGroupId      = DB::table('groups')->where('name', 'Admin')->first()->id;
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
		 * Create default settings.
		 */
        DB::table('settings')->insert(
        	[

        	]
        );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users')->truncate();
		DB::table('groups')->truncate();
		DB::table('permissions')->truncate();
		DB::table('groups_permissions')->truncate();
		DB::table('settings')->truncate();
	}
}
