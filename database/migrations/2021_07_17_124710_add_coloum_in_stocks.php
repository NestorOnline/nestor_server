<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumInStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->decimal('Hold_Qty',10,2)->nullable()->after('Ordered_Qty');
            $table->decimal('New_Ordered_Qty',10,2)->nullable()->after('Hold_Qty');
            $table->decimal('Stock', 10, 2)->change();
            $table->decimal('Ordered_Qty', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['Hold_Qty','New_Ordered_Qty']);
        });
    }
}
