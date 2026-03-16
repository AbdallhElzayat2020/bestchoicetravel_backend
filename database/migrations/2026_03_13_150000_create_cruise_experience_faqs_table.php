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
        Schema::create('cruise_experience_faqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cruise_experience_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('faq_id')
                ->nullable()
                ->constrained('faqs')
                ->onDelete('set null');
            $table->string('question');
            $table->text('answer')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruise_experience_faqs');
    }
};

