<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('Tracking_ID', 255)->nullable()->after('DL_No');
            $table->string('Transport_ID', 255)->nullable()->after('Tracking_ID');
            $table->string('Account_ID', 255)->nullable()->after('Transport_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['Tracking_ID', 'Transport_ID', 'Account_ID']);

        });
    }
}