<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoiceproducts', function (Blueprint $table) {
             $table->increments('id');
             $table->string('invoice_id');
             $table->string('order_id');
             $table->string('product_code');
             $table->string('Scheme_Code');
             $table->string('Order_Qty');
             $table->string('Rate');
             $table->string('Amount');
             $table->string('Discount');
             $table->string('pincode');
             $table->string('city');
             $table->string('state');
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
        Schema::dropIfExists('invoiceproducts');
    }
}
