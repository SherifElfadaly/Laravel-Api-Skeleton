<?php

namespace App\Modules\OauthClients\Database\Seeds;

use Illuminate\Database\Seeder;

class OauthClientsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(OauthClientsTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
