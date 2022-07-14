<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnSalesschameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('sales_schemes', function (Blueprint $table) {
             $table->integer('schemefor')->nullable()->after('Office_Code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_schemes', function (Blueprint $table) {
            $table->dropColumn(['schemefor']);
        });
    }
}
