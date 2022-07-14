<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_schemes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('SalesScheme_Code');
            $table->string('SalesScheme_Name');
            $table->string('SchemeOn_Code');
            $table->string('Product_Code');
            $table->string('SchemeOn');
            $table->string('DiscountType_Code');
            $table->string('Discount'); 
            $table->string('NextMinSaleQty_ForScheme'); 
            $table->string('Free_Qty'); 
            $table->string('Effective_From'); 
            $table->string('Effective_To'); 
            $table->string('Office_Code'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_schemes');
    }
}
