<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('clients', function($table) {
             $table->string('cts',200);
             $table->string('sales_rep',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('clients', function($table) {
        $table->dropColumn('cts');
        $table->dropColumn('sales_rep');
    });
    }
}
