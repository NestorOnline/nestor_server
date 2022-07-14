<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnDoctorappointmentIdInDoctorPrescriptionProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_prescription_products', function (Blueprint $table) {
            $table->Biginteger('doctorappointment_id')->nullable()->after('patient_detail_id');
            $table->Biginteger('user_id')->nullable()->after('doctorappointment_id');
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
            $table->dropColumn(['doctorappointment_id', 'user_id']);
        });
    }
}
