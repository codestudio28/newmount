<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayeeInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('payees', function($table) {
             $table->string('address',200);
             $table->string('contactnumber',200);
             $table->string('tin',200);
             $table->string('remarks',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('payees', function($table) {
        $table->dropColumn('address');
        $table->dropColumn('contactnumber');
         $table->dropColumn('tin');
          $table->dropColumn('remarks');
    });
    }
}
