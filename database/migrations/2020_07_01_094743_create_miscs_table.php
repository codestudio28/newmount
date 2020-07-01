<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMiscsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miscs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger(' client_id');
            $table->bigInteger('property_id');
            $table->string('date',100);
            $table->string('balance',100);
            $table->string('misc_fee',100);
            $table->string('penalty',100);
            $table->string('payment',100);
            $table->string('payment_type',100);
            $table->string('aror',100);
            $table->string('checknumber',100);
            $table->string('bankname',100);
            $table->string('branch',100);
            $table->string('datepaid',100);
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
        Schema::drop('miscs');
    }
}
