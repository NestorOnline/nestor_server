<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardReferenceLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_reference_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('Reference')->nullable();
            $table->timestamp('Date_Time')->nullable();
$table->Biginteger('Debit')->nullable();
$table->Biginteger('Credit')->nullable();
$table->Biginteger('Balance')->nullable();
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
        Schema::dropIfExists('reward_reference_ledgers');
    }
}
