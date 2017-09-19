<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_shifts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->string('hour');
            $table->string('user_id');
            $table->string('observation')->nullable();
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
        Schema::dropIfExists('book_shifts');
    }
}
