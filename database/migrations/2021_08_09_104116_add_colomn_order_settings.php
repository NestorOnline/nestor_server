<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnOrderSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_settings', function (Blueprint $table) {
              $table->renameColumn('MinimumOrderValue', 'MinimumOrderValueForChemist');
             $table->decimal('MinimumOrderValueForCustomer', 10, 2)->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('order_settings', function (Blueprint $table) {
            $table->dropColumn(['MinimumOrderValueForCustomer','MinimumOrderValueForChemist']);
        });
    }
}
