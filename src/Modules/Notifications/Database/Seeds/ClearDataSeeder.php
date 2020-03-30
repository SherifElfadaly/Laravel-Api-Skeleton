<?php

namespace App\Modules\Notifications\Database\Seeds;

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
        $permissions = \DB::table('permissions')->whereIn('model', ['notification', 'pushNotificationDevice']);
        \DB::table('permission_role')->whereIn('permission_id', $permissions->pluck('id'))->delete();
        $permissions->delete();
    }
}
