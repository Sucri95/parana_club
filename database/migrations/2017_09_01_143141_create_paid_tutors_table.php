<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_tutors', function (Blueprint $table) {
            $table->increments('id');
            /*TUTOR A PAGAR */
            $table->integer('tutor_user_id')->unsigned()->index();
            $table->foreign('tutor_user_id')->references('id')->on('users')->onDelete('cascade');
            /*QUIEN REALIZO EL PAGO */
            $table->integer('responsable_user_id')->unsigned()->index();
            $table->foreign('responsable_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('amount');
            $table->string('status');
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
        Schema::dropIfExists('paid_tutors');
    }
}
