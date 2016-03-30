<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignPermissions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Assign the permissions to the admin group.
		 */
		$permissionIds = DB::table('permissions')->select('id')->lists('id');
		$adminGroupId  = DB::table('groups')->where('name', 'Admin')->first()->id;
		foreach ($permissionIds as $permissionId) 
		{
			DB::table('groups_permissions')->insert(
				[
				'permission_id' => $permissionId,
				'group_id'      => $adminGroupId,
				'created_at'    => \DB::raw('NOW()'),
				'updated_at'    => \DB::raw('NOW()')
				]
			);
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
