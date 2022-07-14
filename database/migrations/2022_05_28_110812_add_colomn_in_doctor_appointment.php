<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInDoctorAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctorappointments', function (Blueprint $table) {
            $table->timestamp('schedule_date')->nullable()->after('schedule_id');
            $table->string('schedule_time')->nullable()->after('schedule_date');
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
            $table->dropColumn(['schedule_time', 'schedule_time']);
        });
    }
}