<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesByUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes_by_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quizzes_id')->unsigned()->index();
            $table->foreign('quizzes_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('quizzes_options_id')->unsigned()->index();
            $table->foreign('quizzes_options_id')->references('id')->on('quizzes_options')->onDelete('cascade');
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
        Schema::dropIfExists('quizzes_by_user');
    }
}
