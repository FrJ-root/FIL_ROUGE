<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('company_name');
            $table->enum('transport_type', ['Tourist vehicle', 'Plane', 'Train', 'Horse', 'Camel', 'Bus'])->default('Tourist vehicle');
            $table->string('license_number')->unique();
            $table->string('address');
            $table->string('phone');
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transports');
    }
    
};