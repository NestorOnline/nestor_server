<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInDoctorappointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctorappointments', function (Blueprint $table) {
            $table->string('user_id', 255)->nullable()->after('file_attechment');
            $table->string('doctor_id', 255)->nullable()->after('user_id');
            $table->string('schedule_id', 255)->nullable()->after('doctor_id');
            $table->string('status')->nullable()->after('schedule_id');
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
            $table->dropColumn(['user_id', 'doctor_id', 'schedule_id', 'status']);
        });
    }
}