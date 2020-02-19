<?php

namespace App\Modules\Core\Database\Seeds;

use Illuminate\Database\Seeder;

class CoreDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
