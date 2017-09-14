<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responsable_user_id')->unsigned()->index();
            $table->foreign('responsable_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('client_user_id')->nullable()->unsigned()->index();
            $table->foreign('client_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('type_cash_transactions_id')->unsigned()->index();
            $table->foreign('type_cash_transactions_id')->references('id')->on('type_cash_transactions')->onDelete('cascade');
            $table->integer('amount');
            $table->string('meta'); //COULD BE 'sales', 'planes'
            $table->integer('meta_id');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('cash_transactions');
    }
}
