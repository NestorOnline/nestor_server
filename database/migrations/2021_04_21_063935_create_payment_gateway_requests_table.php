<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewayRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateway_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('PaymentRequest_Code')->nullable();
            $table->timestamp('PaymentRequest_Time')->nullable();
            $table->string('PaymentGateway_Code')->nullable();
            $table->integer('Party_Code')->nullable();
            $table->integer('Order_Code')->nullable();
            $table->string('Requested_Amount')->nullable();
            $table->string('Channel_Id')->nullable();
            $table->string('CheckSumHash')->nullable();
            $table->integer('Mobile_No')->nullable();
            $table->string('Email')->nullable();
            $table->integer('Industry_Type_Id')->nullable();
            $table->string('Callback_URL')->nullable();
            $table->string('ResponseTransID')->nullable();
            $table->string('BankTransID')->nullable();
            $table->string('Received_Amount')->nullable();
            $table->string('TransStatus')->nullable();
            $table->string('Response_Code')->nullable();
            $table->integer('Response_ID')->nullable();
            $table->timestamp('TransactionTime')->nullable();
            $table->string('GatewayName')->nullable();
            $table->string('BankName')->nullable();
            $table->string('PaymentMode')->nullable();
            $table->string('CheckSumHashResponse')->nullable();
            $table->string('BIN_Number')->nullable();
            $table->string('Card_Last_Nums')->nullable();
            $table->string('PaymentReceipt_Code')->nullable();
            $table->timestamp('Updated_Date')->nullable();
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
        Schema::dropIfExists('payment_gateway_requests');
    }
}
