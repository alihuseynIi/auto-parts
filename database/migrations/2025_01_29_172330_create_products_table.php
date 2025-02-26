<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('oem_code')->nullable();
            $table->string('name');
            $table->integer('product_type')->nullable();
            $table->integer('brand')->nullable();
            $table->integer('product_category')->nullable();
            $table->integer('car_brand')->nullable();
            $table->integer('car_model')->nullable();
            $table->integer('stock')->default(1);
            $table->double('price');
            $table->double('discounted_price')->nullable();
            $table->string('image')->nullable();
            $table->boolean('campaign')->default(false);
            $table->boolean('new_product')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
