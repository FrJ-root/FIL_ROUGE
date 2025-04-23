<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('hotel_id')->nullable()->after('guide_id')->constrained()->onDelete('cascade');
        });
        
        if (Schema::hasColumn('reviews', 'guide_id')) {
            DB::statement('ALTER TABLE reviews MODIFY guide_id BIGINT UNSIGNED NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('reviews', 'guide_id')) {
            DB::statement('ALTER TABLE reviews MODIFY guide_id BIGINT UNSIGNED NOT NULL');
        }
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['hotel_id']);
            $table->dropColumn('hotel_id');
        });
    }
};
