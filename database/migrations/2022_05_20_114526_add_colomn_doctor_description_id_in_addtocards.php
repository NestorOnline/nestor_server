<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnDoctorDescriptionIdInAddtocards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addtocards', function (Blueprint $table) {
            $table->string('doctor_description_id')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addtocards', function (Blueprint $table) {
            $table->dropColumn(['doctor_description_id']);
        });
    }
}