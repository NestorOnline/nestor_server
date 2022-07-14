<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderreceivedfromsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderreceivedfroms', function (Blueprint $table) {
            $table->id();
            $table->integer('OrderReceivedFrom_Code')->nullable();
            $table->string('OrderReceivedFrom_Name')->nullable();
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
        Schema::dropIfExists('orderreceivedfroms');
    }
}
