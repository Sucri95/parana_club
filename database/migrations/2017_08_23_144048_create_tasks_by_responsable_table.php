<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksByResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_by_responsable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responsable_user_id')->unsigned()->index();
            $table->foreign('responsable_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('tasks_id')->unsigned()->index();
            $table->foreign('tasks_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_by_responsable');
    }
}
