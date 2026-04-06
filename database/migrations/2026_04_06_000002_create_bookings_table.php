<?php
// database/migrations/2026_04_06_000002_create_bookings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('event_name', 200);
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('booked_by', 100);
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('participants_count')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->text('additional_info')->nullable();
            $table->timestamps();
            
            // Индекс для быстрого поиска
            $table->index(['date', 'room_id']);
            $table->index('status');
            $table->index('booked_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}