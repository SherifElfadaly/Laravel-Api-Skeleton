<?php

namespace App\Modules\Roles\Database\Seeds;

use Illuminate\Database\Seeder;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
