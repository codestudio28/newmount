<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addabout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('abouts', function($table) {
             $table->string('banner',100);
             $table->string('content',10000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('abouts', function($table) {
         $table->dropColumn('banner');
          $table->dropColumn('content');
    });
    }
}
