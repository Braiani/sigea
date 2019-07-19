<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterIntentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intentions', function (Blueprint $table) {
            $table->boolean('avaliacao_coord')->default(false)->after('avaliado_cerel');
            $table->integer('avaliado_coord')->default(0)->after('avaliacao_coord');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intentions', function (Blueprint $table) {
            $table->dropColumn('avaliacao_coord');
            $table->dropColumn('avaliado_coord');
        });
    }
}
