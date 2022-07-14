<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_questions', function (Blueprint $table) {
             $table->id();
            $table->integer('dependent_option_id')->nullable();
            $table->integer('dependent_question_id')->nullable();
            $table->string('question',2000)->nullable();
            $table->string('question_type',20)->nullable();
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
        Schema::dropIfExists('chat_questions');
    }
}