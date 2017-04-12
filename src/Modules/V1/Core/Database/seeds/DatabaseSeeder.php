<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
    	$this->call(LogsTableSeeder::class);
    	$this->call(SettingsTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
