<?php

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
        DB::table('permissions')->insert(
        	[
        		/**
        		 * Permissions model permissions.
        		 */
        		[
	        	'name'       => 'find',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'search',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'list',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'findby',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'first',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginate',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'paginateby',
	        	'model'      => 'permissions',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	]
        	]
        );
    }
}
