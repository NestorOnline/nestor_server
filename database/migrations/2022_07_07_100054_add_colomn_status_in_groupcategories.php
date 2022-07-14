<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnStatusInGroupcategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groupcategories', function (Blueprint $table) {
            $table->Biginteger('status')->nullable()->after('is_home');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groupcategories', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
