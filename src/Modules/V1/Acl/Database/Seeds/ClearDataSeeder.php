<?php

namespace App\Modules\V1\Acl\Database\Seeds;

use Illuminate\Database\Seeder;

class ClearDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \DB::table('permissions')->whereIn('model', ['users', 'permissions', 'groups']);

        \DB::table('groups_permissions')->whereIn('permission_id', $permissions->pluck('id'))->delete();
        \DB::table('users_groups')->delete();

        \DB::table('users')->delete();
        \DB::table('groups')->delete();
        
        $permissions->delete();
    }
}
