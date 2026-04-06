<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;

// Главная страница - открывает index.blade.php
Route::get('/', [MeetingController::class, 'index'])->name('home');

// Остальные маршруты (для вашего функционала)
Route::get('/rooms', [MeetingController::class, 'rooms'])->name('rooms');
Route::get('/rooms/{id}', [MeetingController::class, 'showRoom'])->name('room.show');
Route::get('/booking/create', [MeetingController::class, 'createBooking'])->name('booking.create');
Route::post('/booking/store', [MeetingController::class, 'storeBooking'])->name('booking.store');
Route::get('/my-bookings', [MeetingController::class, 'myBookings'])->name('my.bookings');