<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingRoom extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'equipment',
        'is_active',
        'description'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}