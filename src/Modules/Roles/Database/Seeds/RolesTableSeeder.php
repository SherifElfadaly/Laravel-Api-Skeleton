<?php

namespace App\Modules\Roles\Database\Seeds;

use App\Modules\Roles\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use App\Modules\Roles\Role;
use App\Modules\Users\AclUser;

class RolesTableSeeder extends Seeder
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
        Role::updateOrInsert([
            'name' => RoleEnum::ADMIN,
        ]);
  
        /**
         * Create Default user.
         */
        AclUser::firstOrCreate([
            'email' => config('role.admin_email'),
        ],[
            'name'       => 'Admin',
            'password'   => config('role.admin_password'),
            'confirmed'  => 1
        ]);

        /**
         * Assign default users to admin roles.
         */
        $adminRoleId = Role::where('name', RoleEnum::ADMIN)->select('id')->first()->id;;
        $adminUserId = AclUser::where('email', 'admin@user.com')->select('id')->first()->id;
        \DB::table('role_user')->updateOrInsert([
            'user_id' => $adminUserId,
            'role_id' => $adminRoleId,
        ],[]);

        /**
         * Insert the permissions related to roles table.
         */
        \DB::table('permissions')->insert(
            [
                /**
                 * Roles model permissions.
                 */
                [
                'name'       => 'index',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'show',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'store',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'update',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'destroy',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'deleted',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'restore',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
                [
                'name'       => 'assignPermissions',
                'model'      => 'role',
                'created_at' => \DB::raw('NOW()'),
                'updated_at' => \DB::raw('NOW()')
                ],
            ]
        );
    }
}
