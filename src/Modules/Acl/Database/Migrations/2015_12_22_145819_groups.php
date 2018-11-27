<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Groups extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name',100)->unique();
			$table->softDeletes();
			$table->timestamps();
		});
        
		Schema::create('users_groups', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id');
			$table->softDeletes();
			$table->timestamps();

			$table->index(['user_id']);
		});
        
		/**
		 * Create Default groups.
		 */
		\DB::table('groups')->insert(
			[
				[
					'name'       => 'Admin',
					'created_at' => \DB::raw('NOW()'),
					'updated_at' => \DB::raw('NOW()')
				]
			]
		);
        
		/**
		 * Assign default users to admin groups.
		 */
		$adminGroupId = \DB::table('groups')->where('name', 'admin')->select('id')->first()->id;
		$adminUserId  = \DB::table('users')->where('email', 'admin@user.com')->select('id')->first()->id;
		\DB::table('users_groups')->insert(
			[
			'user_id'    => $adminUserId,
			'group_id'   => $adminGroupId,
			'created_at' => \DB::raw('NOW()'),
			'updated_at' => \DB::raw('NOW()')
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
		Schema::dropIfExists('groups');
		Schema::dropIfExists('users_groups');
	}
}