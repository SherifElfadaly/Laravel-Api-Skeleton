<?php

namespace App\Modules\Reporting\Database\Seeds;

use Illuminate\Database\Seeder;

class ReportingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(ReportsTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
