<?php
// app/Models/Room.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'capacity', 'equipment', 
        'location', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];

    // Связь с бронированиями
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Получить активные бронирования на сегодня
    public function activeBookingsToday()
    {
        return $this->bookings()
            ->where('date', date('Y-m-d'))
            ->where('status', 'confirmed')
            ->get();
    }

    // Проверка доступности комнаты в определенное время
    public function isAvailable($date, $start_time, $end_time, $except_booking_id = null)
    {
        $query = $this->bookings()
            ->where('date', $date)
            ->where('status', 'confirmed')
            ->where(function($q) use ($start_time, $end_time) {
                $q->whereBetween('start_time', [$start_time, $end_time])
                  ->orWhereBetween('end_time', [$start_time, $end_time])
                  ->orWhere(function($q) use ($start_time, $end_time) {
                      $q->where('start_time', '<=', $start_time)
                        ->where('end_time', '>=', $end_time);
                  });
            });

        if ($except_booking_id) {
            $query->where('id', '!=', $except_booking_id);
        }

        return !$query->exists();
    }
}