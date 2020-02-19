<?php

namespace App\Modules\Reporting\Database\Seeds;

use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
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
                 * Reporting model permissions.
                 */
                [
                'name'       => 'find',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'search',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'list',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'findby',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'first',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'paginate',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'paginateby',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'admin_count',
                'model'      => 'reports',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ]
            ]
        );
    }
}
