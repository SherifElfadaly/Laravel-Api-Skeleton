<?php

namespace App\Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
