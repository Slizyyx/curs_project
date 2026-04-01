<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'user_name',
        'user_email',
        'event_name',
        'date',
        'start_time',
        'end_time',
        'status',
        'description'
    ];
    
    protected $casts = [
        'date' => 'date'
    ];
    
    public function room()
    {
        return $this->belongsTo(MeetingRoom::class);
    }
}