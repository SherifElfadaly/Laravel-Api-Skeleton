<?php

namespace App\Modules\PushNotificationDevices\Database\Seeds;

use Illuminate\Database\Seeder;

class PushNotificationDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Insert the permissions related to settings table.
         */
        \DB::table('permissions')->insert(
            [
                /**
                 * pushNotificationDevices model permissions.
                 */
                [
                'name'       => 'index',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'show',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'store',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'update',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'destroy',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'deleted',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'restore',
                'model'      => 'pushNotificationDevice',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ]
            ]
        );
    }
}
