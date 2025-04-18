<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('license_number')->nullable();
            $table->string('specialization')->nullable();
            $table->text('preferred_locations')->nullable();
            $table->text('selected_dates')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('availability', ['available', 'not available'])->default('not available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guides');
    }

};