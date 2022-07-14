<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
             $table->increments('id');
             $table->string('user_role');
             $table->string('user_id');
             $table->string('first_name');
             $table->string('last_name');
             $table->string('address');
             $table->string('landmark');
             $table->string('alternate_mobile');
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
        Schema::dropIfExists('orders');
    }
}
