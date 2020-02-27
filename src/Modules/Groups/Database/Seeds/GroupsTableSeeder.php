<?php

namespace App\Modules\Groups\Database\Seeds;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Insert the permissions related to groups table.
         */
        \DB::table('permissions')->insert(
            [
                /**
                 * Groups model permissions.
                 */
                [
                'name'       => 'index',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'find',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'insert',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'update',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'delete',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'deleted',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'restore',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'assignPermissions',
                'model'      => 'group',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
            ]
        );
    }
}
