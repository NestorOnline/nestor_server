<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnDoctorTypeInDoctorappointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctorappointments', function (Blueprint $table) {
            $table->Biginteger('doctor_type')->nullable()->after('doctor_id');
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
            $table->dropColumn(['doctor_type']);
        });
    }
}