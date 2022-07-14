<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInTablePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('COMMISSION', 20, 2)->nullable()->after('PaymentMode');
            $table->timestamp('PAYOUT_DATE')->nullable()->after('COMMISSION');
            $table->timestamp('SETTLED_DATE')->nullable()->after('PAYOUT_DATE');
            $table->decimal('SETTLEDAMOUNT', 20, 2)->nullable()->after('SETTLED_DATE');
            $table->string('UTR')->nullable()->after('SETTLEDAMOUNT');
            $table->string('SETTLED_ORDERID')->nullable()->after('UTR');
            $table->decimal('GST', 20, 2)->nullable()->after('SETTLED_ORDERID');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['COMMISSION', 'PAYOUT_DATE', 'SETTLED_DATE', 'SETTLEDAMOUNT', 'UTR', 'SETTLED_ORDERID', 'GST']);

        });
    }
}