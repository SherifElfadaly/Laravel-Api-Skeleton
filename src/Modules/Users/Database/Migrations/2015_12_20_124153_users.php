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
            $table->string('profile_picture', 150)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->boolean('blocked')->default(0);
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->string('locale', 2)->default('en');
            $table->string('timezone', 50)->default('Africa/Cairo');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
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
