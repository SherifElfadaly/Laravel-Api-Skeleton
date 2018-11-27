<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Permissions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 100);
			$table->string('model', 100);
			$table->softDeletes();
			$table->timestamps();
			$table->unique(array('name', 'model'));
		});
		Schema::create('groups_permissions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('group_id');
			$table->integer('permission_id');
			$table->softDeletes();
			$table->timestamps();

			$table->index(['group_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('permissions');
		Schema::dropIfExists('groups_permissions');
	}
}