<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PushNotificationDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notification_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_token');
            $table->unsignedInteger('user_id');
            $table->text('access_token')->nullable();
            $table->unique(array('device_token', 'user_id'));
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('push_notification_devices');
    }
}
