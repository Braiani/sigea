<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculaAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matricula_alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula_id');
            $table->string('semestre');
            $table->timestamps();

            $table->foreign('matricula_id')->references('id')->on('matriculas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matricula_alerts');
    }
}
