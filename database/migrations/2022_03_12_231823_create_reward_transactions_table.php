<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('Transaction_Date')->nullable();
$table->Biginteger('RewardPointOf_Code')->nullable();
$table->Biginteger('Reference_Code')->nullable();
$table->Biginteger('RewardTransactionType_Code')->nullable();
$table->Biginteger('Points')->nullable();
$table->Biginteger('user_id')->nullable();
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
        Schema::dropIfExists('reward_transactions');
    }
}
