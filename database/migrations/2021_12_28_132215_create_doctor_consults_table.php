<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorConsultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_consults', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('order_id')->nullable();
            $table->Biginteger('user_id')->nullable();
            $table->Biginteger('Party_Code')->nullable();
            $table->string('upload_prescription')->nullable();
            $table->string('free_doctor_consult', 50)->nullable();
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
        Schema::dropIfExists('doctor_consults');
    }
}