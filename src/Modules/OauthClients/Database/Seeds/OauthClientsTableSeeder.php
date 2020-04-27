<?php

namespace App\Modules\OauthClients\Database\Seeds;

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Insert the permissions related to oauthClients table.
         */
        \DB::table('permissions')->insert(
            [
                /**
                 * OauthClients model permissions.
                 */
                [
                'name'       => 'index',
                'model'      => 'oauthClient',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'show',
                'model'      => 'oauthClient',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'store',
                'model'      => 'oauthClient',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'update',
                'model'      => 'oauthClient',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'revoke',
                'model'      => 'oauthClient',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'unRevoke',
                'model'      => 'oauthClient',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
            ]
        );
    }
}
