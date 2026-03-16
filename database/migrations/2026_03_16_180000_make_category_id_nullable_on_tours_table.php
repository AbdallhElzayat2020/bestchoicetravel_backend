<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            // Drop existing foreign key first (created by constrained())
            $table->dropForeign(['category_id']);
        });

        // Use raw SQL to avoid doctrine/dbal requirement for ->change()
        DB::statement('ALTER TABLE `tours` MODIFY `category_id` BIGINT UNSIGNED NULL');

        Schema::table('tours', function (Blueprint $table) {
            // Re-add FK with SET NULL since category is nullable
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        DB::statement('ALTER TABLE `tours` MODIFY `category_id` BIGINT UNSIGNED NOT NULL');

        Schema::table('tours', function (Blueprint $table) {
            // Restore original behavior
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
        });
    }
};

