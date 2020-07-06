<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payee_id');
            $table->string('amount',100);
            $table->string('cv',100);
            $table->string('bank',100);
            $table->string('cheque',100);
            $table->string('terms',100);
            $table->string('dates',100);
            $table->bigInteger('prepared_admin_id');
            $table->bigInteger('noted_admin_id');
            $table->bigInteger('approved_admin_id');
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
        Schema::drop('vouchers');
    }
}
