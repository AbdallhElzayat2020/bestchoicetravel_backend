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
        Schema::table('cruise_experiences', function (Blueprint $table) {
            $table->string('h1_title')->nullable()->after('title');
            $table->string('h2_title')->nullable()->after('h1_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruise_experiences', function (Blueprint $table) {
            $table->dropColumn(['h1_title', 'h2_title']);
        });
    }
};
