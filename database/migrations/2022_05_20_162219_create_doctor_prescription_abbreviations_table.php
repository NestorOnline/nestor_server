<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPrescriptionAbbreviationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_prescription_abbreviations', function (Blueprint $table) {
            $table->id();
            $table->string('abbreviation_code')->nullable();
            $table->string('description', 500)->nullable();
            $table->Biginteger('prescription_type')->nullable();
            $table->decimal('quantity_in_a_day', 20, 2)->nullable();
            $table->decimal('per_time_taken', 20, 2)->nullable();
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
        Schema::dropIfExists('doctor_prescription_abbreviations');
    }
}