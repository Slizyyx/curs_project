<?php

use App\Http\Controllers\MeetingRoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MeetingRoomController::class, 'index'])->name('home');