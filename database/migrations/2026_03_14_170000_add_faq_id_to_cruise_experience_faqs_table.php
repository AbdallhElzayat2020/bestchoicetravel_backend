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
        if (Schema::hasTable('cruise_experience_faqs') && !Schema::hasColumn('cruise_experience_faqs', 'faq_id')) {
            Schema::table('cruise_experience_faqs', function (Blueprint $table) {
                $table->foreignId('faq_id')
                    ->nullable()
                    ->after('cruise_experience_id')
                    ->constrained('faqs')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cruise_experience_faqs') && Schema::hasColumn('cruise_experience_faqs', 'faq_id')) {
            Schema::table('cruise_experience_faqs', function (Blueprint $table) {
                $table->dropForeign(['faq_id']);
                $table->dropColumn('faq_id');
            });
        }
    }
};

