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
        Schema::table('tour_seasonal_prices', function (Blueprint $table) {
            // Add price_value column if not exists
            if (!Schema::hasColumn('tour_seasonal_prices', 'price_value')) {
                $table->decimal('price_value', 10, 2)->default(0)->after('end_month');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_seasonal_prices', function (Blueprint $table) {
            if (Schema::hasColumn('tour_seasonal_prices', 'price_value')) {
                $table->dropColumn('price_value');
            }
        });
    }
};
