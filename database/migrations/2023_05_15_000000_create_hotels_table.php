<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('price_per_night', 8, 2)->default(0);
            $table->decimal('longitude', 10, 7)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->integer('available_rooms')->nullable();
            $table->integer('star_rating')->default(0);
            $table->string('availability')->nullable();
            $table->text('selected_dates')->nullable();
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->string('image')->nullable();
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotels');
    }
};
