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
        // First add nullable hotel_id column
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('hotel_id')->nullable()->after('guide_id')->constrained()->onDelete('cascade');
        });
        
        // For the guide_id column, we'll use a direct SQL query instead of change()
        if (Schema::hasColumn('reviews', 'guide_id')) {
            // Make guide_id nullable using raw SQL
            DB::statement('ALTER TABLE reviews MODIFY guide_id BIGINT UNSIGNED NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First restore guide_id to not nullable
        if (Schema::hasColumn('reviews', 'guide_id')) {
            // Make guide_id required again using raw SQL
            DB::statement('ALTER TABLE reviews MODIFY guide_id BIGINT UNSIGNED NOT NULL');
        }
        
        // Then drop hotel_id column
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
            $table->dropColumn('hotel_id');
        });
    }
};
