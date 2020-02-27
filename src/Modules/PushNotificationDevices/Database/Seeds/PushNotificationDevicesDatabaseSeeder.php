<?php

namespace App\Modules\PushNotificationDevices\Database\Seeds;

use Illuminate\Database\Seeder;

class PushNotificationDevicesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ClearDataSeeder::class);
        $this->call(PushNotificationDevicesTableSeeder::class);
        $this->call(AssignRelationsSeeder::class);
    }
}
