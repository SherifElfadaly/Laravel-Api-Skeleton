<?php

namespace App\Modules\Core\Database\Seeds;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
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
				 * Settings model permissions.
				 */
				[
				'name'       => 'save',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'find',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'search',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'list',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'findby',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'first',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginate',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginateby',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'saveMany',
				'model'      => 'settings',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				]
			]
		);
	}
}
