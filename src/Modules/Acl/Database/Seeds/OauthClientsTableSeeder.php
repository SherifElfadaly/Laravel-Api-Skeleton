<?php

namespace App\Modules\Acl\Database\Seeds;

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
				 * Users model permissions.
				 */
				[
				'name'       => 'list',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'find',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'search',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginate',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'revoke',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'unRevoke',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'first',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'findby',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'paginateby',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				],
				[
				'name'       => 'save',
				'model'      => 'oauthClients',
				'created_at' => \DB::raw('NOW()'),
				'updated_at' => \DB::raw('NOW()')
				]
			]
		);
	}
}
