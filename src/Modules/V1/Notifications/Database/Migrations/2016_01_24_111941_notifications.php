<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifications extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function (Blueprint $table) {
			$table->increments('id');
			$table->string('key', 100);
            $table->text('data');
			$table->string('item_name',100);
			$table->string('item_type',100);
			$table->integer('item_id');
			$table->boolean('notified');
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
		Schema::drop('notifications');
	}
}