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
        Schema::create('cruise_catalog_category_faq', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_catalog_category_id')
                ->constrained('cruise_catalog_categories')
                ->cascadeOnDelete();
            $table->foreignId('faq_id')
                ->constrained('faqs')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(
                ['cruise_catalog_category_id', 'faq_id'],
                'cc_category_faq_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruise_catalog_category_faq');
    }
};
