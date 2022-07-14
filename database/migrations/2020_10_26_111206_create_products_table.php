<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('generic_name');
            $table->string('brand_name');
            $table->string('composition');
            $table->string('package_id');
            $table->string('product_code');
            $table->string('OrderQtyMultipleOf');
            $table->string('manufacture');
            $table->string('storage');
            $table->string('image');
            $table->string('mrp_amount');
            $table->string('offer');
            $table->string('group_id');
            $table->string('category_id');
            $table->string('actual_amount');          
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
        Schema::dropIfExists('products');
    }
}
