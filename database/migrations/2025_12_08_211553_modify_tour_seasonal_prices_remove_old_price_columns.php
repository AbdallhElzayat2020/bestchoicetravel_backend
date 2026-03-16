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
            // Remove old price columns
            if (Schema::hasColumn('tour_seasonal_prices', 'single_room_price')) {
                $table->dropColumn('single_room_price');
            }
            if (Schema::hasColumn('tour_seasonal_prices', 'double_room_price')) {
                $table->dropColumn('double_room_price');
            }
            if (Schema::hasColumn('tour_seasonal_prices', 'triple_room_price')) {
                $table->dropColumn('triple_room_price');
            }
            // Add description column if not exists
            if (!Schema::hasColumn('tour_seasonal_prices', 'description')) {
                $table->text('description')->nullable()->after('end_month');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_seasonal_prices', function (Blueprint $table) {
            $table->decimal('single_room_price', 10, 2)->default(0)->after('end_month');
            $table->decimal('double_room_price', 10, 2)->default(0)->after('single_room_price');
            $table->decimal('triple_room_price', 10, 2)->nullable()->after('double_room_price');
            if (Schema::hasColumn('tour_seasonal_prices', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
