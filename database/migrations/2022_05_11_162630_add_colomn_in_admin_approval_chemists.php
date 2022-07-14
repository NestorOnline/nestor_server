<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInAdminApprovalChemists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chemists', function (Blueprint $table) {
            $table->Biginteger('admin_approval')->nullable()->after('ApprovalSatus_Code');
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
            $table->dropColumn(['admin_approval']);
        });
    }
}