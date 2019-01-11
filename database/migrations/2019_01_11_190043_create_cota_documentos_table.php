<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotaDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cota_documento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('documento_matriculas_id');
            $table->unsignedInteger('cota_matriculas_id');

            $table->foreign('documento_matriculas_id')->references('id')->on('documento_matriculas');
            $table->foreign('cota_matriculas_id')->references('id')->on('cota_matriculas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cota_documento');
    }
}
