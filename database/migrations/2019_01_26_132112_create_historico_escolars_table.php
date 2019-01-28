<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoEscolarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_escolares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('aluno_id');
            $table->unsignedInteger('disciplina_curso_id');
            $table->string('status');

            $table->foreign('aluno_id')->references('id')->on('alunos');
            $table->foreign('disciplina_curso_id')->references('id')->on('disciplina_cursos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_escolares');
    }
}
