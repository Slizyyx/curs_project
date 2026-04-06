<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    // Главная страница
    public function index()
    {
        // Получаем активные комнаты
        $rooms = Room::where('is_active', true)->get();
        
        // Получаем последние 10 подтверждённых бронирований
        $recentBookings = Booking::with('room')
            ->where('status', 'confirmed')
            ->where('date', '>=', date('Y-m-d'))
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get();
        
        // Возвращаем шаблон index.blade.php с данными
        return view('index', compact('rooms', 'recentBookings'));
    }