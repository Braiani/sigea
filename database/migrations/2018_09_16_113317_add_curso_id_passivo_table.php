<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCursoIdPassivoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passivos', function (Blueprint $table) {
            $table->string('curso')->nullable()->change();
            $table->unsignedInteger('curso_id')->nullable()->after('nome');

            $table->foreign('curso_id')->references('id')->on('cursos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passivos', function (Blueprint $table) {
            $table->string('curso')->change();
            $table->dropForeign(['curso_id']);
            $table->dropColumn('curso_id');
        });
    }
}
