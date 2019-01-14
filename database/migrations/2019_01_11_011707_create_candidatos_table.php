<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->integer('pontuacao');
            $table->unsignedInteger('cota_candidato');
            $table->unsignedInteger('cota_ingresso')->nullable();
            $table->unsignedInteger('chamada')->nullable();
            $table->unsignedInteger('status_matricula_id')->nullable();
            $table->string('observacao')->nullable();
            $table->unsignedInteger('classificacao');
            $table->string('cpf');
            $table->unsignedInteger('curso_id');
            $table->string('periodo');
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('email');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('cota_candidato')->references('id')->on('cota_matriculas');
            $table->foreign('cota_ingresso')->references('id')->on('cota_matriculas');
            $table->foreign('status_matricula_id')->references('id')->on('status_matriculas');
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
}
