<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PushNotificationsDevices extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('push_notifications_devices', function (Blueprint $table) {
			$table->increments('id');
			$table->string('device_token');
			$table->integer('user_id');
			$table->text('login_token')->nullable();
			$table->unique(array('device_token', 'user_id'));
			$table->softDeletes();
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
		Schema::dropIfExists('push_notifications_devices');
	}
}