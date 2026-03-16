<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add new fields only if they don't exist
            if (!Schema::hasColumn('bookings', 'full_name')) {
                $table->string('full_name')->nullable()->after('tour_id');
            }
            if (!Schema::hasColumn('bookings', 'nationality')) {
                $table->string('nationality')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('bookings', 'no_of_travellers')) {
                $table->integer('no_of_travellers')->default(1)->after('phone');
            }
        });

        // Migrate existing data: combine first_name and last_name to full_name
        if (Schema::hasColumn('bookings', 'first_name') && Schema::hasColumn('bookings', 'last_name')) {
            \DB::statement("UPDATE bookings SET full_name = TRIM(CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, ''))) WHERE (full_name IS NULL OR full_name = '') AND (first_name IS NOT NULL OR last_name IS NOT NULL)");
        }

        // Fill default values for new fields
        \DB::statement("UPDATE bookings SET nationality = 'Not Specified' WHERE nationality IS NULL OR nationality = ''");
        \DB::statement("UPDATE bookings SET no_of_travellers = 1 WHERE no_of_travellers IS NULL OR no_of_travellers = 0");

        Schema::table('bookings', function (Blueprint $table) {
            // Drop old columns after migration
            if (Schema::hasColumn('bookings', 'first_name')) {
                $table->dropColumn('first_name');
            }
            if (Schema::hasColumn('bookings', 'last_name')) {
                $table->dropColumn('last_name');
            }

            // Make new fields required (after filling data) - only if they exist
            if (Schema::hasColumn('bookings', 'full_name')) {
                $table->string('full_name')->nullable(false)->change();
            }
            if (Schema::hasColumn('bookings', 'nationality')) {
                $table->string('nationality')->nullable(false)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add back old columns
            $table->string('first_name')->nullable()->after('tour_id');
            $table->string('last_name')->nullable()->after('first_name');

            // Drop new columns
            $table->dropColumn(['full_name', 'nationality', 'no_of_travellers']);
        });
    }
};
