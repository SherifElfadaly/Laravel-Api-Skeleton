<?php

namespace App\Modules\Permissions\Database\Seeds;

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
        $adminRoleId = \DB::table('roles')->where('name', 'admin')->select('id')->first()->id;

        /**
         * Assign the permissions to the admin role.
         */
        \DB::table('permissions')->orderBy('created_at', 'asc')->whereIn('model', ['permission'])->each(function ($permission) use ($adminRoleId) {
            \DB::table('roles_permissions')->insert(
                [
                'permission_id' => $permission->id,
                'role_id'      => $adminRoleId,
                'created_at'    => \DB::raw('NOW()'),
                'updated_at'    => \DB::raw('NOW()')
                ]
            );
        });
    }
}
