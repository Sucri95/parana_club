<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quizzes_id')->unsigned()->index();
            $table->foreign('quizzes_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->string('option');
            $table->integer('answer');
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
        Schema::dropIfExists('quizzes_options');
    }
}
