<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->unsignedInteger('registro_situacao_id')->nullable()->after('id_curso');

            $table->foreign('registro_situacao_id')->references('id')->on('registro_situacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['registro_situacao_id']);

            $table->dropColumn('registro_situacao_id');
        });
    }
}
