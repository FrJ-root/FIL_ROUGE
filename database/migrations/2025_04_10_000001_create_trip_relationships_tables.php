<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Categories <-> Trips pivot table
        Schema::create('trip_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'category_id']);
        });
        
        // Tags <-> Trips pivot table
        Schema::create('trip_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'tag_id']);
        });
        
        // TransportCompanies <-> Trips pivot table
        Schema::create('trip_transport_company', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('transport_company_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'transport_company_id']);
        });
        
        // Guides <-> Trips pivot table
        Schema::create('trip_guide', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('guide_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'guide_id']);
        });
        
        // Hotels <-> Trips pivot table
        Schema::create('trip_hotel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'hotel_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('trip_hotel');
        Schema::dropIfExists('trip_guide');
        Schema::dropIfExists('trip_transport_company');
        Schema::dropIfExists('trip_tag');
        Schema::dropIfExists('trip_category');
    }
};
