<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('room');
        
        // Фильтр по статусу
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Фильтр по датам
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
        
        $bookings = $query->orderBy('date', 'desc')
                         ->orderBy('start_time')
                         ->paginate(15);
        
        return view('bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $rooms = Room::where('is_active', true)->get();
        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'event_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'participants_count' => 'nullable|integer|min:1',
            'booked_by' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'additional_info' => 'nullable|string'
        ]);
        
        // Проверка доступности комнаты
        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailable($validated['date'], $validated['start_time'], $validated['end_time'])) {
            return back()->with('error', 'Комната уже забронирована на выбранное время')
                        ->withInput();
        }
        
        // Проверка вместимости
        if ($validated['participants_count'] && $validated['participants_count'] > $room->capacity) {
            return back()->with('error', 'Количество участников превышает вместимость комнаты')
                        ->withInput();
        }
        
        $validated['status'] = 'pending';
        Booking::create($validated);
        
        return redirect()->route('bookings.index')
                        ->with('success', 'Бронирование успешно создано!');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::where('is_active', true)->get();
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'event_name' => 'required|string|max:200',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'participants_count' => 'nullable|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'booked_by' => 'required|string|max:100',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:20',
            'additional_info' => 'nullable|string'
        ]);
        
        // Проверка доступности (исключая текущее бронирование)
        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailable($validated['date'], $validated['start_time'], $validated['end_time'], $booking->id)) {
            return back()->with('error', 'Комната уже забронирована на выбранное время')
                        ->withInput();
        }
        
        $booking->update($validated);
        
        return redirect()->route('bookings.index')
                        ->with('success', 'Бронирование обновлено');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('bookings.index')
                        ->with('success', 'Бронирование отменено');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')
                        ->with('success', 'Бронирование удалено');
    }
}