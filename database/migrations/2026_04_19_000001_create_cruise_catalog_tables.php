<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Cruise catalog (admin): category → programs (with day-by-day) → vessels (3 prices + gallery) ↔ programs.
     */
    public function up(): void
    {
        Schema::create('cruise_catalog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status', 20)->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cruise_catalog_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_catalog_category_id')
                ->constrained('cruise_catalog_categories')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->unsignedSmallInteger('duration_days')->default(1);
            $table->string('status', 20)->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cruise_catalog_program_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_catalog_program_id')
                ->constrained('cruise_catalog_programs')
                ->cascadeOnDelete();
            $table->unsignedSmallInteger('day_number')->default(1);
            $table->string('day_title');
            $table->string('day_status', 20)->default('active');
            $table->text('details')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cruise_catalog_vessels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_catalog_category_id')
                ->constrained('cruise_catalog_categories')
                ->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->decimal('price_tier_1', 12, 2)->default(0);
            $table->decimal('price_tier_2', 12, 2)->default(0);
            $table->decimal('price_tier_3', 12, 2)->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('status', 20)->default('active');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cruise_catalog_vessel_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_catalog_vessel_id')
                ->constrained('cruise_catalog_vessels')
                ->cascadeOnDelete();
            $table->string('image_path');
            $table->string('alt')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('cruise_catalog_program_vessel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_catalog_vessel_id')
                ->constrained('cruise_catalog_vessels')
                ->cascadeOnDelete();
            $table->foreignId('cruise_catalog_program_id')
                ->constrained('cruise_catalog_programs')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(
                ['cruise_catalog_vessel_id', 'cruise_catalog_program_id'],
                'cc_prog_vessel_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruise_catalog_program_vessel');
        Schema::dropIfExists('cruise_catalog_vessel_images');
        Schema::dropIfExists('cruise_catalog_vessels');
        Schema::dropIfExists('cruise_catalog_program_days');
        Schema::dropIfExists('cruise_catalog_programs');
        Schema::dropIfExists('cruise_catalog_categories');
    }
};
