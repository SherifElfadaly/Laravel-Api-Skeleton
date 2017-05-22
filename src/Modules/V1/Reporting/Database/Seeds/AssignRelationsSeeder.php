<?php

namespace App\Modules\V1\Reporting\Database\Seeds;

use Illuminate\Database\Seeder;

class AssignRelationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        /**
		 * Assign the permissions to the admin group.
		 */
    	$adminGroupId = \DB::table('groups')->where('name', 'admin')->select('id')->first()->id;

        /**
         * Assign the permissions to the admin group.
         */
        \DB::table('permissions')->orderBy('created_at', 'asc')->whereIn('model', ['reports'])->each(function ($permission) use ($adminGroupId) {
        	\DB::table('groups_permissions')->insert(
				[
				'permission_id' => $permission->id,
				'group_id'      => $adminGroupId,
				'created_at'    => \DB::raw('NOW()'),
				'updated_at'    => \DB::raw('NOW()')
				]
			);
        });
    }
}
