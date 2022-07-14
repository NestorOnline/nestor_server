<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColomnInChatQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_queries', function (Blueprint $table) {
            $table->string('name')->nullable()->after('chat_question_id');
            $table->string('image')->nullable()->after('name');
            $table->string('order_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_queries', function (Blueprint $table) {
            $table->dropColumn(['name', 'image']);
        });
    }
}