<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trip_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'category_id']);
        });
        
        Schema::create('trip_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'tag_id']);
        });
        
        Schema::create('trip_transport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('transport_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'transport_id']);
        });
        
        Schema::create('trip_guide', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained()->onDelete('cascade');
            $table->foreignId('guide_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['trip_id', 'guide_id']);
        });
        
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
        Schema::dropIfExists('trip_transport');
        Schema::dropIfExists('trip_tag');
        Schema::dropIfExists('trip_category');
    }
};
