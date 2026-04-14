<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);
Route::get('bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
Route::get('rooms/{room}/availability', [RoomController::class, 'checkAvailability'])->name('rooms.availability');