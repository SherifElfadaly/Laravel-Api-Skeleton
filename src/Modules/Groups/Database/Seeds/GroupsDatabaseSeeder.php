<?php

namespace App\Modules\Groups\Database\Seeds;

use Illuminate\Database\Seeder;

class GroupsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
