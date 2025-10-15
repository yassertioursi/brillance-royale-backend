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
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('promo_price', 10, 2)->nullable();
            $table->boolean('is_promo')->default(false);
            $table->timestamp('promo_start_date')->nullable();
            $table->timestamp('promo_end_date')->nullable();
            $table->unsignedInteger('stock_quantity')->default(0);
            $table->text('description')->nullable();
            $table->string('brand')->nullable();
            $table->string('reference')->nullable();
            $table->json('images')->nullable();
            $table->json('size_prices')->nullable();
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
