<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroughtalsoproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broughtalsoproducts', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('Prodoct_Code')->nullable();
            $table->Biginteger('Link_Prodoct_Code')->nullable();
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
        Schema::dropIfExists('broughtalsoproducts');
    }
}
