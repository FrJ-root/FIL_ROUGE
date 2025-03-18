<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('itineraries', function (Blueprint $table) {
            $table->foreignId('trip_id')->unique()->constrained('trips')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropForeign(['trip_id']);
            $table->dropColumn('trip_id');
        });
    }
};