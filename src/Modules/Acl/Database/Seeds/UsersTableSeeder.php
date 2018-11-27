<?php

namespace App\Modules\Acl\Database\Seeds;

use Illuminate\Database\Seeder;

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
		 * Insert the permissions related to users table.
		 */
		\DB::table('permissions')->insert(
			[
				/**
				 * Users model permissions.
				 */
				[
				'name'       => 'save',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'delete',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'find',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'list',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'search',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'findby',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'first',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginate',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginateby',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'assigngroups',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'block',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'unblock',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'group',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'deleted',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'restore',
				'model'      => 'users',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				]
			]
		);
	}
}
