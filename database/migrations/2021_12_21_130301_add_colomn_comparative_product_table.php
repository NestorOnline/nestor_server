<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnComparativeProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comparative_products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->nullable()->change();
            $table->decimal('b2c_price', 20, 2)->nullable()->after('price');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comparative_products', function (Blueprint $table) {
            $table->dropColumn(['b2c_price']);
        });

    }
}