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
        if (!Schema::hasTable('tour_seasonal_prices')) {
            Schema::create('tour_seasonal_prices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
                $table->string('season_name'); // e.g., "Summer", "Winter", "MAY-SEP", "OCT-APR"
                $table->integer('start_month'); // 1-12 (January to December)
                $table->integer('end_month'); // 1-12 (January to December)
                $table->text('description')->nullable(); // Description for the season
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            // Table exists, modify it
            Schema::table('tour_seasonal_prices', function (Blueprint $table) {
                // Remove old price columns if they exist
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_seasonal_prices');
    }
};
