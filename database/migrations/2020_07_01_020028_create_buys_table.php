<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_id');
            $table->bigInteger('property_id');
            $table->bigInteger('paymentscheme_id');
            $table->string('tcp',100);
            $table->string('loanable',100);
            $table->string('totalequity',100);
            $table->string('totalmisc',100);
            $table->string('misc',100);
            $table->string('equity',100);
            $table->integer('months');
            $table->string('reservationfee',100);
            $table->string('misc_penalty',100);
            $table->string('equity_penalty',100);
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
        Schema::drop('buys');
    }
}
