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
        Schema::table('tours', function (Blueprint $table) {
            $table->string('cover_image_alt')->nullable()->after('cover_image');
        });

        Schema::table('tour_images', function (Blueprint $table) {
            $table->string('alt')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('cover_image_alt');
        });

        Schema::table('tour_images', function (Blueprint $table) {
            $table->dropColumn('alt');
        });
    }
};
