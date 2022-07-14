<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInBroughtAlsoProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('broughtalsoproducts', function (Blueprint $table) {
            $table->string('link_group')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('broughtalsoproducts', function (Blueprint $table) {
            $table->dropColumn(['link_group']);
        });
    }
}
