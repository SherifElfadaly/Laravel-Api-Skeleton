<?php

namespace App\Modules\DummyModule\Database\Seeds;

use Illuminate\Database\Seeder;

class DummyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(DummyTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
