<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Roles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('users_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
        
        /**
         * Create Default roles.
         */
        \DB::table('roles')->insert(
            [
                [
                    'name'       => 'Admin',
                    'created_at' => \DB::raw('NOW()'),
                    'updated_at' => \DB::raw('NOW()')
                ]
            ]
        );
        
        /**
         * Assign default users to admin roles.
         */
        $adminRoleId = \DB::table('roles')->where('name', 'admin')->select('id')->first()->id;
        $adminUserId  = \DB::table('users')->where('email', 'admin@user.com')->select('id')->first()->id;
        \DB::table('users_roles')->insert(
            [
            'user_id'    => $adminUserId,
            'role_id'   => $adminRoleId,
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users_roles');
    }
}
