<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SampelReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE VIEW admin_count AS  
			select count(u.id)
			from users u, roles g ,role_user ug
			where
			ug.user_id  = u.id and
			ug.role_id = g.id 
			");
        
        DB::table('reports')->insert(
            [
                [
                'report_name' => 'admin_count',
                'view_name'   => 'admin_count',
                'created_at'  => \DB::raw('NOW()'),
                'updated_at'  => \DB::raw('NOW()')
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS admin_count");
    }
}
