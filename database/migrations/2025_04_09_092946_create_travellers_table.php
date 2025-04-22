<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('travellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('itinerary_id')->constrained('itineraries')->onDelete('cascade');
            $table->string('passport_number')->nullable();
            $table->string('prefered_destination')->nullable();
            $table->string('nationality')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'cancelled', 'refunded'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('travellers');
    }

};