<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intentions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula_id');
            $table->unsignedInteger('subject_id');
            $table->string('semestre');
            $table->boolean('avaliado_cerel')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('matricula_id')->references('id')->on('matriculas');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intentions');
    }
}
