<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCotaMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cota_matriculas', function (Blueprint $table) {
            $table->boolean('analise_renda')->nullable()->after('sigla');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cota_matriculas', function (Blueprint $table) {
            $table->dropColumn('analise_renda');
        });
    }
}
