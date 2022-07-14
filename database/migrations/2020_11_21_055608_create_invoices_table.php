<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
             $table->increments('id');
             $table->string('user_role');
             $table->string('user_id');
             $table->string('order_id');
             $table->string('first_name');
             $table->string('last_name');
             $table->string('address');
             $table->string('landmark');
             $table->string('alternate_mobile');
             $table->string('pincode');
             $table->string('city');
             $table->string('state');
             $table->string('taxable_amount');
             $table->string('tax_amount');
             $table->string('discount');
             $table->string('delivery_amount');
             $table->string('grand_total');
             $table->string('wallet');
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
        Schema::dropIfExists('invoices');
    }
}
