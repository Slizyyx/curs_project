<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms = Room::where('is_active', true)->count();
        $activeBookings = Booking::where('date', Carbon::today())
            ->where('status', 'confirmed')
            ->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        
        $todayBookings = Booking::with('room')
            ->where('date', Carbon::today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('start_time')
            ->get();
        
        $popularRooms = Room::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'totalRooms', 'activeBookings', 'pendingBookings', 
            'todayBookings', 'popularRooms'
        ));
    }
}