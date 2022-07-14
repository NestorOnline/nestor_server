<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPrescriptionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_prescription_products', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('patient_detail_id')->nullable();
            $table->Biginteger('order_id')->nullable();
            $table->Biginteger('doctor_id')->nullable();
            $table->Biginteger('chemist_user_id')->nullable();
            $table->string('product_code', 50)->nullable();
            $table->Biginteger('product_id')->nullable();
            $table->Biginteger('doses_id')->nullable();
            $table->Biginteger('taken_id')->nullable();
            $table->decimal('qty', 10, 2)->nullable();
            $table->decimal('price_per_qty', 10, 2)->nullable();
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
        Schema::dropIfExists('doctor_prescription_products');
    }
}