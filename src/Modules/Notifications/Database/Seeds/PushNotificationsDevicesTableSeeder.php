<?php

namespace App\Modules\Notifications\Database\Seeds;

use Illuminate\Database\Seeder;

class PushNotificationsDevicesTableSeeder extends Seeder
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
				'name'       => 'find',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'search',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'list',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'findby',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'first',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginate',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginateby',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'save',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'delete',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'deleted',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'restore',
				'model'      => 'pushNotificationDevices',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				]
			]
		);
	}
}
