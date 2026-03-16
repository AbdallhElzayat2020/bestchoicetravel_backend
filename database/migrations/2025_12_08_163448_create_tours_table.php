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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();

            // Category and Subcategory
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('set null');

            // Location
            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->constrained('states')->onDelete('set null');

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // SEO Fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Duration
            $table->integer('duration')->default(1);
            $table->enum('duration_type', ['hours', 'days'])->default('days');

            // Cover Image
            $table->string('cover_image')->nullable();

            // Status and Visibility
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('show_on_homepage')->default(false);

            // Pricing
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('has_offer')->default(false);
            $table->decimal('price_before_discount', 10, 2)->nullable();
            $table->decimal('price_after_discount', 10, 2)->nullable();
            $table->date('offer_start_date')->nullable();
            $table->date('offer_end_date')->nullable();

            // Notes (Optional)
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('tours');
    }
};
