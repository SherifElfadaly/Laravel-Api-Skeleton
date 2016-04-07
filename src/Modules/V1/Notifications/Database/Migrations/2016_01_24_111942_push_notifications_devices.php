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
			$table->string('device_token',100);
			$table->enum('device_type', ['android', 'ios']);
			$table->integer('user_id');
			$table->boolean('active')->default(1);
			$table->unique(array('device_token', 'device_type'));
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
		Schema::drop('push_notifications_devices');
	}
}