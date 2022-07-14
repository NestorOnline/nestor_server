<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInPatientDetailIdInDoctorappointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctorappointments', function (Blueprint $table) {
            $table->Biginteger('patient_detail_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctorappointments', function (Blueprint $table) {
            $table->dropColumn(['patient_detail_id']);
        });
    }
}
