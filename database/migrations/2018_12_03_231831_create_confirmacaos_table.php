<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmacaos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('processo_seletivo_id')->unsigned();
            $table->string('cpf', 14);
            $table->string('nome');
            $table->timestamps();
            
            $table->foreign('processo_seletivo_id')->references('id')->on('processo_seletivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmacaos');
    }
}
