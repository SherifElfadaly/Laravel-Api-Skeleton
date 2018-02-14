<?php

namespace App\Modules\V1\Notifications\Database\Seeds;

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
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
        		 * notifications model permissions.
        		 */
	        	[
	        	'name'       => 'all',
	        	'model'      => 'notifications',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'unread',
	        	'model'      => 'notifications',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'markAsRead',
	        	'model'      => 'notifications',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	],
	        	[
	        	'name'       => 'markAllAsRead',
	        	'model'      => 'notifications',
	        	'created_at' => \DB::raw('NOW()'),
	        	'updated_at' => \DB::raw('NOW()')
	        	]
        	]
        );
    }
}
