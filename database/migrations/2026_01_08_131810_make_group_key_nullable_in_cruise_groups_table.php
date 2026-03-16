<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cruise_groups', function (Blueprint $table) {
            $table->string('group_key')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruise_groups', function (Blueprint $table) {
            // Generate group_key from slug for existing records before making it required
            DB::statement("UPDATE cruise_groups SET group_key = slug WHERE group_key IS NULL");
            $table->string('group_key')->nullable(false)->change();
        });
    }
};
