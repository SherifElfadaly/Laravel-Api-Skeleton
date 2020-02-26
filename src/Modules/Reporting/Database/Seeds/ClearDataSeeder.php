<?php

namespace App\Modules\Reporting\Database\Seeds;

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
        $permissions = \DB::table('permissions')->whereIn('model', ['report']);
        \DB::table('groups_permissions')->whereIn('permission_id', $permissions->pluck('id'))->delete();
        $permissions->delete();
    }
}
