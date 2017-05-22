<?php

namespace App\Modules\V1\Acl\Database\Seeds;

use Illuminate\Database\Seeder;

class AclDatabaseSeeder extends Seeder
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
    	$this->call(GroupsTableSeeder::class);
    	$this->call(PermissionsTableSeeder::class);
    	$this->call(AssignRelationsSeeder::class);
    }
}
