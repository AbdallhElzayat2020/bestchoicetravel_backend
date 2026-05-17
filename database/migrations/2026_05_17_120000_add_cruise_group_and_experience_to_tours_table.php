<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            if (! Schema::hasColumn('tours', 'cruise_group_id')) {
                $table->foreignId('cruise_group_id')
                    ->nullable()
                    ->after('sub_category_id')
                    ->constrained('cruise_groups')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('tours', 'cruise_experience_id')) {
                $table->foreignId('cruise_experience_id')
                    ->nullable()
                    ->after('cruise_group_id')
                    ->constrained('cruise_experiences')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('tours', function (Blueprint $table) {
            if (Schema::hasColumn('tours', 'cruise_experience_id')) {
                $table->dropForeign(['cruise_experience_id']);
                $table->dropColumn('cruise_experience_id');
            }

            if (Schema::hasColumn('tours', 'cruise_group_id')) {
                $table->dropForeign(['cruise_group_id']);
                $table->dropColumn('cruise_group_id');
            }
        });
    }
};
