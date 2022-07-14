<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnReturnInOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->string('Received_Qty', 50)->nullable()->after('Order_Qty');
            $table->string('Replace_Qty', 50)->nullable()->after('Received_Qty');
            $table->string('Return_Qty', 50)->nullable()->after('Replace_Qty');
            $table->string('Replace_Product_Taxable_Amount', 50)->nullable()->after('Replace_Qty');
            $table->string('Replace_Product_Total_Amount', 50)->nullable()->after('Replace_Qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn(['Tracking_ID', 'Transport_ID', 'Account_ID']);
        });
    }
}