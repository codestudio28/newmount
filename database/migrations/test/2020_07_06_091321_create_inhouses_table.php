<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInhousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('property_id');
            $table->bigInteger('buy_id');
            $table->bigInteger('paymentscheme_id');
            $table->string('monthly_amort',100);
            $table->string('loanable',100);
            $table->string('date_due',100);
            $table->string('amount_due',100);
            $table->string('unpaid_due',100);
            $table->string('penalty',100);
            $table->string('total_due',100);
            $table->string('payment',100);
            $table->string('balance',100);
            $table->string('or',100);
            $table->string('status',100);
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
        Schema::drop('inhouses');
    }
}
