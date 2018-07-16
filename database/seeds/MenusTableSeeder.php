<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'created_at' => '2018-05-19 19:20:05',
                'updated_at' => '2018-05-19 19:20:05',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'sidebar',
                'created_at' => '2018-05-19 20:08:58',
                'updated_at' => '2018-05-19 20:08:58',
            ),
        ));
        
        
    }
}