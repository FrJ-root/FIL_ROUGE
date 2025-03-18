<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('travellers', function (Blueprint $table) {
            $table->foreignId('itinerary_id')->constrained('itineraries')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('travellers', function (Blueprint $table) {
            $table->dropForeign(['itinerary_id']);
            $table->dropColumn('itinerary_id');
        });
    }
};
