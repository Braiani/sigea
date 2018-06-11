<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_to')->unsigned();
            $table->string('task');
            $table->date('deadline')->nullable();
            $table->boolean('completed')->nullable();
            $table->integer('owner')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_to')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('owner')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
