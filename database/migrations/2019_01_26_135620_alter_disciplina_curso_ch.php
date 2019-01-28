<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDisciplinaCursoCh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disciplina_cursos', function (Blueprint $table) {
            $table->integer('carga_horaria')->nullable()->after('semestre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disciplina_cursos', function (Blueprint $table) {
            $table->dropColumn('carga_horaria');
        });
    }
}
