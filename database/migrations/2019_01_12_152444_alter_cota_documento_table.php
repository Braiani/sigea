<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCotaDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cota_documento', function (Blueprint $table) {
            $table->renameColumn('documento_matriculas_id', 'documento_matricula_id');
            $table->renameColumn('cota_matriculas_id', 'cota_matricula_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cota_documento', function (Blueprint $table) {
            $table->renameColumn('documento_matricula_id', 'documento_matriculas_id');
            $table->renameColumn('cota_matricula_id', 'cota_matriculas_id');
        });
    }
}
