<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->boolean('blocked')->default(0);
			$table->date('last_change_password')->nullable();
            $table->string('two_factor_code', 4)->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

		/**
		 * Create Default users.
		 */
		\DB::table('users')->insertGetId(
            [
			'name'       => 'Admin',
			'email'      => 'admin@user.com',
			'password'   => bcrypt('123456'),
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
		Schema::dropIfExists('users');
	}
}