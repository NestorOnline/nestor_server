<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandGroupGroupcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_group_groupcategories', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('group_id')->nullable();
            $table->Biginteger('group_category_id')->nullable();
            $table->Biginteger('group_category_code')->nullable();
            $table->Biginteger('ProductBrand_Code')->nullable();
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
        Schema::dropIfExists('brand_group_groupcategories');
    }
}