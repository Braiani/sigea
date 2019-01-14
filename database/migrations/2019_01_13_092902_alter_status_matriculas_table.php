<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_matriculas', function (Blueprint $table) {
            $table->boolean('padrao_matriculado')->nullable()->after('descricao');
            $table->boolean('padrao_analise')->nullable()->after('padrao_matriculado');
            $table->boolean('padrao_reclassificacao')->nullable()->after('padrao_analise');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_matriculas', function (Blueprint $table) {
            $table->dropColumn('padrao_matriculado');
            $table->dropColumn('padrao_analise');
            $table->dropColumn('padrao_reclassificacao');
        });
    }
}
