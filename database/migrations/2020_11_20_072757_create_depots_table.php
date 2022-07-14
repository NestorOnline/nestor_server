<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depots', function (Blueprint $table) {
             $table->increments('id');
             $table->string('location');
             $table->string('office_code');
             $table->string('office_name');
             $table->string('address1');
             $table->string('address2');
             $table->string('city_name');
             $table->string('state_name');             
             $table->string('pin');
             $table->string('gst');
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
        Schema::dropIfExists('depots');
    }
}
