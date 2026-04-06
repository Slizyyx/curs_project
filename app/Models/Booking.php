<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'event_name', 'description', 'date', 'start_time', 
        'end_time', 'booked_by', 'email', 'phone', 'participants_count', 
        'status', 'additional_info'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Связь с комнатой
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Аксессор для названия комнаты (для использования в шаблоне)
    public function getRoomNameAttribute()
    {
        return $this->room ? $this->room->name : null;
    }

    // Scope для активных бронирований
    public function scopeActive($query)
    {
        return $query->where('status', 'confirmed')
                     ->where('date', '>=', date('Y-m-d'));
    }

    // Проверка конфликта времени
    public static function checkConflict($room_id, $date, $start_time, $end_time, $except_id = null)
    {
        $query = self::where('room_id', $room_id)
            ->where('date', $date)
            ->where('status', 'confirmed')
            ->where(function($q) use ($start_time, $end_time) {
                $q->where(function($q) use ($start_time, $end_time) {
                    $q->where('start_time', '<', $end_time)
                      ->where('end_time', '>', $start_time);
                });
            });

        if ($except_id) {
            $query->where('id', '!=', $except_id);
        }

        return $query->exists();
    }
}   