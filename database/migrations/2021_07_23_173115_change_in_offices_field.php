<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInOfficesField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->integer('Office_Code')->nullable()->change();
            $table->string('Office_Name')->nullable()->change();
            $table->string('Address1')->nullable()->change();
            $table->string('Address2')->nullable()->change();
            $table->string('Address3')->nullable()->change();
            $table->string('City_Name')->nullable()->change();
            $table->string('State_Name')->nullable()->change();
            $table->integer('PIN')->nullable()->change();
            $table->string('GSTIN')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offices', function (Blueprint $table) {
            //
        });
    }
}
