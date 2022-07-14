<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
           $table->increments('id');
            $table->string('ORDERID');
            $table->string('TXNID');
            $table->string('TXNAMOUNT');
            $table->string('PAYMENTMODE');
            $table->string('CURRENCY');
            $table->string('TXNDATE');
            $table->string('STATUS');
            $table->string('RESPCODE');
            $table->string('RESPMSG');
            $table->string('GATEWAYNAME');
            $table->string('BANKTXNID');
            $table->string('BANKNAME');
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
        Schema::dropIfExists('payments');
    }
}
