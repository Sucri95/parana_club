<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesDaysSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes_days_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_id')->unsigned()->index();
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('day_id')->unsigned()->index();
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->integer('schedule_start_id')->unsigned()->index();
            $table->foreign('schedule_start_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->integer('schedule_end_id')->unsigned()->index();
            $table->foreign('schedule_end_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->integer('value');
            $table->integer('inscribed')->nullable();
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
        Schema::dropIfExists('classes_days_schedules');
    }
}
