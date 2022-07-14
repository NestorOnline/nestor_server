<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('manufacture');
            $table->string('composition');
            $table->string('storage');
            $table->string('description');
            $table->string('uses');
            $table->string('warning_precautions');
            $table->string('interactions');
            $table->string('directions_for_use');
            $table->string('side_effects');
            $table->string('medicine_type');
            $table->string('mrp_price');
            $table->string('offer');
            $table->string('image');
            $table->string('actual_price');          
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
        Schema::dropIfExists('medicines');
    }
}
