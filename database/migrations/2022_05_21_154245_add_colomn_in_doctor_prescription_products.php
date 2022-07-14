<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInDoctorPrescriptionProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_prescription_products', function (Blueprint $table) {
            $table->string('doctor_description_id')->nullable()->after('price_per_qty');
            $table->string('no_of_day')->nullable()->after('doctor_description_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_prescription_products', function (Blueprint $table) {
            $table->dropColumn(['doctor_description_id', 'no_of_day']);
        });
    }
}