<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminTravelController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index']);
    Route::put('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm']);
    Route::put('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel']);
    Route::put('/bookings/{booking}/complete', [AdminBookingController::class, 'complete']);

    Route::post('/travels', [AdminTravelController::class, 'store']);
    Route::put('/travels/{travel}', [AdminTravelController::class, 'update']);
    Route::delete('/travels/{travel}', [AdminTravelController::class, 'destroy']);

    Route::put('/payments/{payment}/verify', [AdminPaymentController::class, 'verify']);
    Route::put('/payments/{payment}/reject', [AdminPaymentController::class, 'reject']);
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/my', [BookingController::class, 'myBookings']);

    Route::post('/payments/{booking}', [PaymentController::class, 'store']);
});

// Public routes
Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{travel}', [TravelController::class, 'show']);