<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnStocksHolds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('stock_holds', function (Blueprint $table) {
            $table->integer('Office_Code')->nullable()->after('Hold_Qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('stock_holds', function (Blueprint $table) {
            $table->dropColumn(['Office_Code']);
        });
    }
}
