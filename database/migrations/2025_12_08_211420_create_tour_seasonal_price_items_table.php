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
        Schema::create('tour_seasonal_price_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seasonal_price_id')->constrained('tour_seasonal_prices')->onDelete('cascade');
            $table->string('price_name'); // e.g., "Single Room", "Double Room", "VIP Suite", etc.
            $table->decimal('price_value', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_seasonal_price_items');
    }
};
