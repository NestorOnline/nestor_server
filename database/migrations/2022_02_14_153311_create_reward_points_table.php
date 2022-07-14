<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewardPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reward_points', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('order_id')->nullable();
            $table->Biginteger('user_id')->nullable();
            $table->string('Order_No')->nullable();
            $table->string('Order_Code')->nullable();
            $table->timestamp('Order_Date')->nullable();
            $table->decimal('Tax_Amount', 20, 2)->nullable();
            $table->decimal('Reward_Point')->nullable();
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
        Schema::dropIfExists('reward_points');
    }
}