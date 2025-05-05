<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('room_id')->constrained()->onDelete('cascade');
                $table->date('check_in');
                $table->date('check_out');
                $table->integer('guests')->default(1);
                $table->decimal('total_price', 10, 2);
                $table->string('status')->default('pending');
                $table->text('special_requests')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('bookings', function (Blueprint $table) {
                if (!Schema::hasColumn('bookings', 'check_in')) {
                    $table->date('check_in')->nullable();
                }
                if (!Schema::hasColumn('bookings', 'check_out')) {
                    $table->date('check_out')->nullable();
                }
                if (!Schema::hasColumn('bookings', 'guests')) {
                    $table->integer('guests')->default(1);
                }
                if (!Schema::hasColumn('bookings', 'total_price')) {
                    $table->decimal('total_price', 10, 2)->nullable();
                }
                if (!Schema::hasColumn('bookings', 'status')) {
                    $table->string('status')->default('pending');
                }
                if (!Schema::hasColumn('bookings', 'special_requests')) {
                    $table->text('special_requests')->nullable();
                }
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
