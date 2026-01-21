<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminTravelController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');
});

Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index']);
    Route::post('/travels', [AdminTravelController::class, 'store']);
    Route::put('/travels/{travel}', [AdminTravelController::class, 'update']);
    Route::delete('/travels/{travel}', [AdminTravelController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/my', [BookingController::class, 'myBookings']);
});

// Public routes
Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{travel}', [TravelController::class, 'show']);