<?php

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-05-19 19:20:03',
                'updated_at' => '2018-05-20 21:21:26',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2018-05-19 19:20:03',
                'updated_at' => '2018-05-19 19:20:03',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2018-05-19 19:20:04',
                'updated_at' => '2018-05-19 19:20:04',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'passivos',
                'slug' => 'passivos',
                'display_name_singular' => 'Passivo',
                'display_name_plural' => 'Passivos',
                'icon' => NULL,
                'model_name' => 'App\\Passivo',
                'policy_name' => NULL,
                'controller' => 'PassivoController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-05-21 05:31:07',
                'updated_at' => '2018-05-23 00:39:34',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'mensagens',
                'slug' => 'mensagens',
                'display_name_singular' => 'Mensagen',
                'display_name_plural' => 'Mensagens',
                'icon' => NULL,
                'model_name' => 'App\\Mensagem',
                'policy_name' => NULL,
                'controller' => 'MensagemController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-05-27 06:47:43',
                'updated_at' => '2018-05-27 06:47:43',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'cursos',
                'slug' => 'cursos',
                'display_name_singular' => 'Curso',
                'display_name_plural' => 'Cursos',
                'icon' => 'voyager-company',
                'model_name' => 'App\\Curso',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-07-09 12:22:53',
                'updated_at' => '2018-07-09 12:22:53',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'alunos',
                'slug' => 'alunos',
                'display_name_singular' => 'Aluno',
                'display_name_plural' => 'Alunos',
                'icon' => 'voyager-person',
                'model_name' => 'App\\Aluno',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-07-09 12:23:17',
                'updated_at' => '2018-07-09 20:13:37',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'disciplina_cursos',
                'slug' => 'disciplina-cursos',
                'display_name_singular' => 'Disciplina Curso',
                'display_name_plural' => 'Disciplina Cursos',
                'icon' => 'voyager-file-text',
                'model_name' => 'App\\DisciplinaCurso',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 1,
                'details' => '{"order_column":null,"order_display_column":null}',
                'created_at' => '2018-07-09 12:26:49',
                'updated_at' => '2018-07-09 18:41:21',
            ),
        ));
        
        
    }
}