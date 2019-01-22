<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Administrator',
                'created_at' => '2018-05-19 19:20:05',
                'updated_at' => '2018-05-19 19:20:05',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'cogea',
                'display_name' => 'COGEA',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-27 05:57:33',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'cerel',
                'display_name' => 'CEREL',
                'created_at' => '2018-05-27 05:57:43',
                'updated_at' => '2018-05-27 05:57:43',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'coords',
                'display_name' => 'Coordenação de curso',
                'created_at' => '2018-07-18 03:39:57',
                'updated_at' => '2018-07-18 03:39:57',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'nuged',
                'display_name' => 'NUGED',
                'created_at' => '2019-01-16 02:07:01',
                'updated_at' => '2019-01-16 02:07:01',
            ),
        ));
        
        
    }
}