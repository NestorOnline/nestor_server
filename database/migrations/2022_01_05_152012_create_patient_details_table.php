<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('user_id')->nullable();
            $table->string('Patient_Name')->nullable();
            $table->string('Patient_Age')->nullable();
            $table->string('Sex')->nullable();
            $table->string('Mobile_No')->nullable();
            $table->string('Food_Allergies')->nullable();
            $table->string('Tendency_Bleed')->nullable();
            $table->string('Heart_Disease')->nullable();
            $table->string('High_Blood_Pressure')->nullable();
            $table->string('Diabetic')->nullable();
            $table->string('Surgery')->nullable();
            $table->string('Accident')->nullable();
            $table->string('Others')->nullable();
            $table->string('Family_Medical_History')->nullable();
            $table->string('Current_Medication')->nullable();
            $table->string('Female_Pregnancy')->nullable();
            $table->string('Breast_Feeding')->nullable();
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
        Schema::dropIfExists('patient_details');
    }
}