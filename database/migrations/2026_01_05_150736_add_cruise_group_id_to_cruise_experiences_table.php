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
            if (!Schema::hasColumn('cruise_experiences', 'cruise_group_id')) {
                $table->foreignId('cruise_group_id')->nullable()->after('group_key')->constrained('cruise_groups')->onDelete('cascade');
                $table->index('cruise_group_id');
            }
        });

        // Migrate existing data: link cruise experiences to cruise groups based on group_key
        if (Schema::hasTable('cruise_groups')) {
            \DB::statement("
                UPDATE cruise_experiences ce
                INNER JOIN cruise_groups cg ON ce.group_key = cg.group_key
                SET ce.cruise_group_id = cg.id
                WHERE ce.cruise_group_id IS NULL
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruise_experiences', function (Blueprint $table) {
            if (Schema::hasColumn('cruise_experiences', 'cruise_group_id')) {
                $table->dropForeign(['cruise_group_id']);
                $table->dropColumn('cruise_group_id');
            }
        });
    }
};
