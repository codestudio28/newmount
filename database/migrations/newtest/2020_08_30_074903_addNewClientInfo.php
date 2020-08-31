<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewClientInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('clients', function($table) {
            $table->string('birthdate',200);
            $table->string('civilstatus',200);
            $table->string('spouse',200);
            $table->string('work',200);
            $table->string('dependent');
            $table->string('address2',200);
            $table->string('zipcode',200);
            $table->string('emailadd',200);
            $table->string('employementstatus',200);
            $table->string('employername',200);
            $table->string('naturebusiness',200);
            $table->string('officeaddress',200);
            $table->string('officenumber',200);
            $table->string('position',200);
            $table->string('basicsalary',200);
            $table->string('allowance',200);
            $table->string('yearsemployed',200);
            $table->string('othersource',200);
            $table->string('living',200);
            $table->string('finance',200);
            $table->string('tin',200);
            $table->string('sss',200);
            $table->string('passport',200);
             $table->string('passportvalid',200);
            $table->string('driver',200);
            $table->string('drivervalid',200);
            $table->string('prc',200);
            $table->string('prcvalid',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //  Schema::table('clients', function($table) {
        //     $table->dropColumn('birthdate');
        //     $table->dropColumn('civilstatus');
        //     $table->dropColumn('spouse');
        //     $table->dropColumn('work');
        //     $table->dropColumn('dependent');
        //     $table->dropColumn('address2');
        //     $table->dropColumn('zipcode');
        // });
    }
}
