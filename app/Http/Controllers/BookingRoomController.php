<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Models\Booking;
use Illuminate\Http\Request;

class MeetingRoomController extends Controller
{
    public function index()
    {
        $rooms = MeetingRoom::where('is_active', true)
                           ->orderBy('name')
                           ->get();
        
        $recentBookings = Booking::with('room')
                                ->where('status', '!=', 'cancelled')
                                ->latest()
                                ->take(5)
                                ->get()
                                ->map(function($booking) {
                                    return (object)[
                                        'room_name' => $booking->room->name ?? 'Неизвестно',
                                        'event_name' => $booking->event_name,
                                        'date' => $booking->date,
                                        'start_time' => $booking->start_time,
                                        'end_time' => $booking->end_time,
                                        'status' => $booking->status
                                    ];
                                });
        
        return view('meeting-rooms.index', compact('rooms', 'recentBookings'));
    }
}