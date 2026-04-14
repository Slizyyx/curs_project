<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 'event_name', 'description', 'date', 
        'start_time', 'end_time', 'booked_by', 'email', 
        'phone', 'participants_count', 'status', 'additional_info'
    ];

    protected $casts = [
        'date' => 'date',
        'participants_count' => 'integer'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger'
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    public function getTimeRangeAttribute()
    {
        return date('H:i', strtotime($this->start_time)) . ' - ' . 
               date('H:i', strtotime($this->end_time));
    }
}