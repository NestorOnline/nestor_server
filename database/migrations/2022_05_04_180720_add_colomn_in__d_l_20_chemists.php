<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInDL20Chemists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chemists', function (Blueprint $table) {
            $table->string('DL_No_21', 255)->nullable()->after('DL_No');
            $table->string('DL_File_21', 255)->nullable()->after('DL_File');
            $table->timestamp('DL_Valid_From')->nullable()->after('Party_Name');
            $table->timestamp('DL_Valid_From_21')->nullable()->after('DL_Valid_From');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chemists', function (Blueprint $table) {
            $table->dropColumn(['DL_No_21', 'DL_File_21', 'DL_Valid_From', 'DL_Valid_From_21']);
        });

    }
}