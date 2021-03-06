<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'browse_admin',
                'table_name' => NULL,
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            1 => 
            array (
                'id' => 2,
                'key' => 'browse_bread',
                'table_name' => NULL,
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            2 => 
            array (
                'id' => 3,
                'key' => 'browse_database',
                'table_name' => NULL,
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            3 => 
            array (
                'id' => 4,
                'key' => 'browse_media',
                'table_name' => NULL,
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            4 => 
            array (
                'id' => 5,
                'key' => 'browse_compass',
                'table_name' => NULL,
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            5 => 
            array (
                'id' => 6,
                'key' => 'browse_menus',
                'table_name' => 'menus',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            6 => 
            array (
                'id' => 7,
                'key' => 'read_menus',
                'table_name' => 'menus',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            7 => 
            array (
                'id' => 8,
                'key' => 'edit_menus',
                'table_name' => 'menus',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            8 => 
            array (
                'id' => 9,
                'key' => 'add_menus',
                'table_name' => 'menus',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            9 => 
            array (
                'id' => 10,
                'key' => 'delete_menus',
                'table_name' => 'menus',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            10 => 
            array (
                'id' => 11,
                'key' => 'browse_roles',
                'table_name' => 'roles',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            11 => 
            array (
                'id' => 12,
                'key' => 'read_roles',
                'table_name' => 'roles',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            12 => 
            array (
                'id' => 13,
                'key' => 'edit_roles',
                'table_name' => 'roles',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            13 => 
            array (
                'id' => 14,
                'key' => 'add_roles',
                'table_name' => 'roles',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            14 => 
            array (
                'id' => 15,
                'key' => 'delete_roles',
                'table_name' => 'roles',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            15 => 
            array (
                'id' => 16,
                'key' => 'browse_users',
                'table_name' => 'users',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            16 => 
            array (
                'id' => 17,
                'key' => 'read_users',
                'table_name' => 'users',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            17 => 
            array (
                'id' => 18,
                'key' => 'edit_users',
                'table_name' => 'users',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            18 => 
            array (
                'id' => 19,
                'key' => 'add_users',
                'table_name' => 'users',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            19 => 
            array (
                'id' => 20,
                'key' => 'delete_users',
                'table_name' => 'users',
                'created_at' => '2018-05-19 19:20:06',
                'updated_at' => '2018-05-19 19:20:06',
            ),
            20 => 
            array (
                'id' => 21,
                'key' => 'browse_settings',
                'table_name' => 'settings',
                'created_at' => '2018-05-19 19:20:07',
                'updated_at' => '2018-05-19 19:20:07',
            ),
            21 => 
            array (
                'id' => 22,
                'key' => 'read_settings',
                'table_name' => 'settings',
                'created_at' => '2018-05-19 19:20:07',
                'updated_at' => '2018-05-19 19:20:07',
            ),
            22 => 
            array (
                'id' => 23,
                'key' => 'edit_settings',
                'table_name' => 'settings',
                'created_at' => '2018-05-19 19:20:07',
                'updated_at' => '2018-05-19 19:20:07',
            ),
            23 => 
            array (
                'id' => 24,
                'key' => 'add_settings',
                'table_name' => 'settings',
                'created_at' => '2018-05-19 19:20:07',
                'updated_at' => '2018-05-19 19:20:07',
            ),
            24 => 
            array (
                'id' => 25,
                'key' => 'delete_settings',
                'table_name' => 'settings',
                'created_at' => '2018-05-19 19:20:07',
                'updated_at' => '2018-05-19 19:20:07',
            ),
            25 => 
            array (
                'id' => 26,
                'key' => 'browse_hooks',
                'table_name' => NULL,
                'created_at' => '2018-05-19 19:20:09',
                'updated_at' => '2018-05-19 19:20:09',
            ),
            26 => 
            array (
                'id' => 27,
                'key' => 'browse_passivos',
                'table_name' => 'passivos',
                'created_at' => '2018-05-21 05:31:07',
                'updated_at' => '2018-05-21 05:31:07',
            ),
            27 => 
            array (
                'id' => 28,
                'key' => 'read_passivos',
                'table_name' => 'passivos',
                'created_at' => '2018-05-21 05:31:07',
                'updated_at' => '2018-05-21 05:31:07',
            ),
            28 => 
            array (
                'id' => 29,
                'key' => 'edit_passivos',
                'table_name' => 'passivos',
                'created_at' => '2018-05-21 05:31:07',
                'updated_at' => '2018-05-21 05:31:07',
            ),
            29 => 
            array (
                'id' => 30,
                'key' => 'add_passivos',
                'table_name' => 'passivos',
                'created_at' => '2018-05-21 05:31:07',
                'updated_at' => '2018-05-21 05:31:07',
            ),
            30 => 
            array (
                'id' => 31,
                'key' => 'delete_passivos',
                'table_name' => 'passivos',
                'created_at' => '2018-05-21 05:31:07',
                'updated_at' => '2018-05-21 05:31:07',
            ),
            31 => 
            array (
                'id' => 32,
                'key' => 'browse_mensagens',
                'table_name' => 'mensagens',
                'created_at' => '2018-05-27 06:47:43',
                'updated_at' => '2018-05-27 06:47:43',
            ),
            32 => 
            array (
                'id' => 33,
                'key' => 'read_mensagens',
                'table_name' => 'mensagens',
                'created_at' => '2018-05-27 06:47:43',
                'updated_at' => '2018-05-27 06:47:43',
            ),
            33 => 
            array (
                'id' => 34,
                'key' => 'edit_mensagens',
                'table_name' => 'mensagens',
                'created_at' => '2018-05-27 06:47:43',
                'updated_at' => '2018-05-27 06:47:43',
            ),
            34 => 
            array (
                'id' => 35,
                'key' => 'add_mensagens',
                'table_name' => 'mensagens',
                'created_at' => '2018-05-27 06:47:43',
                'updated_at' => '2018-05-27 06:47:43',
            ),
            35 => 
            array (
                'id' => 36,
                'key' => 'delete_mensagens',
                'table_name' => 'mensagens',
                'created_at' => '2018-05-27 06:47:43',
                'updated_at' => '2018-05-27 06:47:43',
            ),
            36 => 
            array (
                'id' => 37,
                'key' => 'browse_cursos',
                'table_name' => 'cursos',
                'created_at' => '2018-07-09 12:22:53',
                'updated_at' => '2018-07-09 12:22:53',
            ),
            37 => 
            array (
                'id' => 38,
                'key' => 'read_cursos',
                'table_name' => 'cursos',
                'created_at' => '2018-07-09 12:22:53',
                'updated_at' => '2018-07-09 12:22:53',
            ),
            38 => 
            array (
                'id' => 39,
                'key' => 'edit_cursos',
                'table_name' => 'cursos',
                'created_at' => '2018-07-09 12:22:53',
                'updated_at' => '2018-07-09 12:22:53',
            ),
            39 => 
            array (
                'id' => 40,
                'key' => 'add_cursos',
                'table_name' => 'cursos',
                'created_at' => '2018-07-09 12:22:53',
                'updated_at' => '2018-07-09 12:22:53',
            ),
            40 => 
            array (
                'id' => 41,
                'key' => 'delete_cursos',
                'table_name' => 'cursos',
                'created_at' => '2018-07-09 12:22:53',
                'updated_at' => '2018-07-09 12:22:53',
            ),
            41 => 
            array (
                'id' => 42,
                'key' => 'browse_alunos',
                'table_name' => 'alunos',
                'created_at' => '2018-07-09 12:23:17',
                'updated_at' => '2018-07-09 12:23:17',
            ),
            42 => 
            array (
                'id' => 43,
                'key' => 'read_alunos',
                'table_name' => 'alunos',
                'created_at' => '2018-07-09 12:23:17',
                'updated_at' => '2018-07-09 12:23:17',
            ),
            43 => 
            array (
                'id' => 44,
                'key' => 'edit_alunos',
                'table_name' => 'alunos',
                'created_at' => '2018-07-09 12:23:17',
                'updated_at' => '2018-07-09 12:23:17',
            ),
            44 => 
            array (
                'id' => 45,
                'key' => 'add_alunos',
                'table_name' => 'alunos',
                'created_at' => '2018-07-09 12:23:17',
                'updated_at' => '2018-07-09 12:23:17',
            ),
            45 => 
            array (
                'id' => 46,
                'key' => 'delete_alunos',
                'table_name' => 'alunos',
                'created_at' => '2018-07-09 12:23:17',
                'updated_at' => '2018-07-09 12:23:17',
            ),
            46 => 
            array (
                'id' => 47,
                'key' => 'browse_disciplina_cursos',
                'table_name' => 'disciplina_cursos',
                'created_at' => '2018-07-09 12:26:49',
                'updated_at' => '2018-07-09 12:26:49',
            ),
            47 => 
            array (
                'id' => 48,
                'key' => 'read_disciplina_cursos',
                'table_name' => 'disciplina_cursos',
                'created_at' => '2018-07-09 12:26:49',
                'updated_at' => '2018-07-09 12:26:49',
            ),
            48 => 
            array (
                'id' => 49,
                'key' => 'edit_disciplina_cursos',
                'table_name' => 'disciplina_cursos',
                'created_at' => '2018-07-09 12:26:49',
                'updated_at' => '2018-07-09 12:26:49',
            ),
            49 => 
            array (
                'id' => 50,
                'key' => 'add_disciplina_cursos',
                'table_name' => 'disciplina_cursos',
                'created_at' => '2018-07-09 12:26:49',
                'updated_at' => '2018-07-09 12:26:49',
            ),
            50 => 
            array (
                'id' => 51,
                'key' => 'delete_disciplina_cursos',
                'table_name' => 'disciplina_cursos',
                'created_at' => '2018-07-09 12:26:49',
                'updated_at' => '2018-07-09 12:26:49',
            ),
            51 => 
            array (
                'id' => 52,
                'key' => 'browse_processo_seletivos',
                'table_name' => 'processo_seletivos',
                'created_at' => '2018-12-05 01:01:09',
                'updated_at' => '2018-12-05 01:01:09',
            ),
            52 => 
            array (
                'id' => 53,
                'key' => 'read_processo_seletivos',
                'table_name' => 'processo_seletivos',
                'created_at' => '2018-12-05 01:01:09',
                'updated_at' => '2018-12-05 01:01:09',
            ),
            53 => 
            array (
                'id' => 54,
                'key' => 'edit_processo_seletivos',
                'table_name' => 'processo_seletivos',
                'created_at' => '2018-12-05 01:01:09',
                'updated_at' => '2018-12-05 01:01:09',
            ),
            54 => 
            array (
                'id' => 55,
                'key' => 'add_processo_seletivos',
                'table_name' => 'processo_seletivos',
                'created_at' => '2018-12-05 01:01:09',
                'updated_at' => '2018-12-05 01:01:09',
            ),
            55 => 
            array (
                'id' => 56,
                'key' => 'delete_processo_seletivos',
                'table_name' => 'processo_seletivos',
                'created_at' => '2018-12-05 01:01:09',
                'updated_at' => '2018-12-05 01:01:09',
            ),
            56 => 
            array (
                'id' => 57,
                'key' => 'browse_cota_matriculas',
                'table_name' => 'cota_matriculas',
                'created_at' => '2019-01-14 03:10:14',
                'updated_at' => '2019-01-14 03:10:14',
            ),
            57 => 
            array (
                'id' => 58,
                'key' => 'read_cota_matriculas',
                'table_name' => 'cota_matriculas',
                'created_at' => '2019-01-14 03:10:14',
                'updated_at' => '2019-01-14 03:10:14',
            ),
            58 => 
            array (
                'id' => 59,
                'key' => 'edit_cota_matriculas',
                'table_name' => 'cota_matriculas',
                'created_at' => '2019-01-14 03:10:14',
                'updated_at' => '2019-01-14 03:10:14',
            ),
            59 => 
            array (
                'id' => 60,
                'key' => 'add_cota_matriculas',
                'table_name' => 'cota_matriculas',
                'created_at' => '2019-01-14 03:10:14',
                'updated_at' => '2019-01-14 03:10:14',
            ),
            60 => 
            array (
                'id' => 61,
                'key' => 'delete_cota_matriculas',
                'table_name' => 'cota_matriculas',
                'created_at' => '2019-01-14 03:10:14',
                'updated_at' => '2019-01-14 03:10:14',
            ),
            61 => 
            array (
                'id' => 62,
                'key' => 'browse_documento_matriculas',
                'table_name' => 'documento_matriculas',
                'created_at' => '2019-01-14 03:11:03',
                'updated_at' => '2019-01-14 03:11:03',
            ),
            62 => 
            array (
                'id' => 63,
                'key' => 'read_documento_matriculas',
                'table_name' => 'documento_matriculas',
                'created_at' => '2019-01-14 03:11:03',
                'updated_at' => '2019-01-14 03:11:03',
            ),
            63 => 
            array (
                'id' => 64,
                'key' => 'edit_documento_matriculas',
                'table_name' => 'documento_matriculas',
                'created_at' => '2019-01-14 03:11:03',
                'updated_at' => '2019-01-14 03:11:03',
            ),
            64 => 
            array (
                'id' => 65,
                'key' => 'add_documento_matriculas',
                'table_name' => 'documento_matriculas',
                'created_at' => '2019-01-14 03:11:03',
                'updated_at' => '2019-01-14 03:11:03',
            ),
            65 => 
            array (
                'id' => 66,
                'key' => 'delete_documento_matriculas',
                'table_name' => 'documento_matriculas',
                'created_at' => '2019-01-14 03:11:03',
                'updated_at' => '2019-01-14 03:11:03',
            ),
            66 => 
            array (
                'id' => 67,
                'key' => 'browse_status_matriculas',
                'table_name' => 'status_matriculas',
                'created_at' => '2019-01-14 03:12:46',
                'updated_at' => '2019-01-14 03:12:46',
            ),
            67 => 
            array (
                'id' => 68,
                'key' => 'read_status_matriculas',
                'table_name' => 'status_matriculas',
                'created_at' => '2019-01-14 03:12:46',
                'updated_at' => '2019-01-14 03:12:46',
            ),
            68 => 
            array (
                'id' => 69,
                'key' => 'edit_status_matriculas',
                'table_name' => 'status_matriculas',
                'created_at' => '2019-01-14 03:12:46',
                'updated_at' => '2019-01-14 03:12:46',
            ),
            69 => 
            array (
                'id' => 70,
                'key' => 'add_status_matriculas',
                'table_name' => 'status_matriculas',
                'created_at' => '2019-01-14 03:12:46',
                'updated_at' => '2019-01-14 03:12:46',
            ),
            70 => 
            array (
                'id' => 71,
                'key' => 'delete_status_matriculas',
                'table_name' => 'status_matriculas',
                'created_at' => '2019-01-14 03:12:46',
                'updated_at' => '2019-01-14 03:12:46',
            ),
            71 => 
            array (
                'id' => 72,
                'key' => 'browse_candidatos',
                'table_name' => 'candidatos',
                'created_at' => '2019-01-21 23:27:54',
                'updated_at' => '2019-01-21 23:27:54',
            ),
            72 => 
            array (
                'id' => 73,
                'key' => 'read_candidatos',
                'table_name' => 'candidatos',
                'created_at' => '2019-01-21 23:27:54',
                'updated_at' => '2019-01-21 23:27:54',
            ),
            73 => 
            array (
                'id' => 74,
                'key' => 'edit_candidatos',
                'table_name' => 'candidatos',
                'created_at' => '2019-01-21 23:27:54',
                'updated_at' => '2019-01-21 23:27:54',
            ),
            74 => 
            array (
                'id' => 75,
                'key' => 'add_candidatos',
                'table_name' => 'candidatos',
                'created_at' => '2019-01-21 23:27:54',
                'updated_at' => '2019-01-21 23:27:54',
            ),
            75 => 
            array (
                'id' => 76,
                'key' => 'delete_candidatos',
                'table_name' => 'candidatos',
                'created_at' => '2019-01-21 23:27:54',
                'updated_at' => '2019-01-21 23:27:54',
            ),
        ));
        
        
    }
}