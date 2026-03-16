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
        // Modify existing tour_variants table to be standalone
        Schema::table('tour_variants', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['tour_id']);
            // Drop tour_id column
            $table->dropColumn('tour_id');
            // Add image column
            $table->string('image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_variants', function (Blueprint $table) {
            // Add tour_id back
            $table->foreignId('tour_id')->nullable()->after('id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            // Drop image column
            $table->dropColumn('image');
        });
    }
};
