<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashierClosingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_closing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responsable_user_id')->unsigned()->index();
            $table->foreign('responsable_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('amount_deposits');
            $table->integer('amount_diff')->nullable();
            $table->integer('amount_cash');
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
        Schema::dropIfExists('cashier_closing');
    }
}
