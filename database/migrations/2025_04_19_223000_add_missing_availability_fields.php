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
        if (!Schema::hasColumn('hotels', 'availability')) {
            Schema::table('hotels', function (Blueprint $table) {
                $table->enum('availability', ['available', 'not available'])->default('not available');
                $table->text('selected_dates')->nullable();
                $table->integer('available_rooms')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            if (Schema::hasColumn('hotels', 'availability')) {
                $table->dropColumn(['availability', 'selected_dates', 'available_rooms']);
            }
        });
    }
};
