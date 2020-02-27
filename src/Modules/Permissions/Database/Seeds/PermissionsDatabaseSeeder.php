<?php

namespace App\Modules\Permissions\Database\Seeds;

use Illuminate\Database\Seeder;

class PermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
