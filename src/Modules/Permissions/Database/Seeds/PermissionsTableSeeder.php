<?php

namespace App\Modules\Permissions\Database\Seeds;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Insert the permissions related to permissions table.
         */
        \DB::table('permissions')->insert(
            [
                /**
                 * Permissions model permissions.
                 */
                [
                'name'       => 'index',
                'model'      => 'permission',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'show',
                'model'      => 'permission',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
            ]
        );
    }
}
