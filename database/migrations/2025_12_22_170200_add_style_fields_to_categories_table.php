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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('grid_columns')->default('4')->after('sort_order'); // 2, 3, 4
            $table->text('custom_css')->nullable()->after('grid_columns');
            $table->string('header_background_color')->nullable()->after('custom_css');
            $table->string('header_text_color')->nullable()->after('header_background_color');
            $table->string('card_style')->default('default')->after('header_text_color'); // default, modern, classic
            $table->boolean('show_breadcrumb')->default(true)->after('card_style');
            $table->boolean('show_description')->default(true)->after('show_breadcrumb');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'grid_columns',
                'custom_css',
                'header_background_color',
                'header_text_color',
                'card_style',
                'show_breadcrumb',
                'show_description'
            ]);
        });
    }
};
