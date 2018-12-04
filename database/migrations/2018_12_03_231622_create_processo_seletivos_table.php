<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessoSeletivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processo_seletivos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('edital');
            $table->text('descricao')->nullable();
            $table->integer('user_id')->unsigned()->default(1);
            $table->timestamps();
            
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
        Schema::dropIfExists('processo_seletivos');
    }
}
