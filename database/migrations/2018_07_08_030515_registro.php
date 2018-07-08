<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Registro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_disciplina_cursos')->unsigned();
            $table->integer('id_alunos')->unsigned();
            $table->string('semestre');
            $table->integer('situacao')->unsigned();
            $table->integer('avaliacao')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->timestamps();

            $table->foreign('id_disciplina_cursos')->references('id')->on('disciplina_cursos')->onDelete('cascade');
            $table->foreign('id_alunos')->references('id')->on('alunos')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registros');
    }
}
