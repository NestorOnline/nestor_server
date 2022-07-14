<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInPaymentGateways extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->string('PaymentGateway_MKey', 255)->nullable()->after('PaymentGateway_Name');
            $table->string('PaymentGateway_MId', 255)->nullable()->after('PaymentGateway_MKey');
            $table->string('PaymentGateway_MWebsite', 255)->nullable()->after('PaymentGateway_MId');
            $table->string('PaymentGateway_Channel', 255)->nullable()->after('PaymentGateway_MWebsite');
            $table->string('PaymentGateway_IndustryType', 255)->nullable()->after('PaymentGateway_Channel');
            $table->string('PaymentGateway_Callback_Url', 1000)->nullable()->after('PaymentGateway_IndustryType');
            $table->string('PaymentGateway_Mode', 255)->nullable()->after('PaymentGateway_Callback_Url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->dropColumn(['PaymentGateway_MKey', 'PaymentGateway_MId', 'PaymentGateway_MWebsite', 'PaymentGateway_Channel', 'PaymentGateway_IndustryType', 'PaymentGateway_Callback_Url', 'PaymentGateway_Mode']);
        });
    }
}