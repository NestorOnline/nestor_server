<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColomnInOrderProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
             $table->decimal('Order_Qty',10,2)->nullable()->change();
            $table->decimal('Free_Qty',10,2)->nullable()->change();
            $table->decimal('MRP',10,2)->nullable()->change();
            $table->decimal('Rate',10,2)->nullable()->change();
            $table->decimal('Discount',10,2)->nullable()->change();
            $table->decimal('Amount',10,2)->nullable()->change();
            $table->decimal('Tax',10,2)->nullable()->change();
            $table->decimal('Total',10,2)->nullable()->change();
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
            //
        });
    }
}