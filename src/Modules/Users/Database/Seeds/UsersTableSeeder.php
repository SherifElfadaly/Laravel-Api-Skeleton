<?php

namespace App\Modules\Users\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Users\AclUser;
use App\Modules\Roles\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create Default roles.
         */
        $role = Role::updateOrInsert([
            'name' => 'Admin',
        ],[
            'created_at' => \DB::raw('NOW()'),
            'updated_at' => \DB::raw('NOW()')
        ]);

        /**
         * Create Default user.
         */
        AclUser::updateOrInsert([
            'email' => 'admin@user.com',
        ],[
            'name'       => 'Admin',
            'password'   => \Hash::make('123456'),
            'confirmed'  => 1,
            'created_at' => \DB::raw('NOW()'),
            'updated_at' => \DB::raw('NOW()')
        ]);

        /**
         * Insert the permissions related to users table.
         */
        \DB::table('permissions')->insert(
            [
                /**
                 * Users model permissions.
                 */
                [
                'name'       => 'index',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'find',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'insert',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'update',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'delete',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'deleted',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'restore',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'assignRoles',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'block',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'unblock',
                'model'      => 'user',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ]
            ]
        );
    }
}
