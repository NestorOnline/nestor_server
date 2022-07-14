<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChemistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chemists', function (Blueprint $table) {
             $table->increments('id');
             $table->string('chemist_name');
             $table->string('chemist_mobile');
             $table->string('chemist_code');
             $table->string('chemist_drug_license_no');
             $table->string('chemist_user_id');
             $table->string('chemist_geolocation');
             $table->string('chemist_address');             
             $table->string('chemist_state');
             $table->string('chemist_city');
             $table->string('chemist_pin');
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
        Schema::dropIfExists('chemists');
    }
}
