<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'travel'])
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'List of all bookings for admin',
            'data' => $bookings,
        ]);
    }

    public function confirm(Booking $booking)
    {
        if ($booking->status !== BookingStatus::PAID->value) {
            return response()->json([
                'success' => false,
                'message' => 'Only PAID booking can be confirmed',
            ], 422);
        }

        $booking->update([
            'status' => BookingStatus::CONFIRMED,
            'paid_at' => now(),
            'confirmed_at' => now(),
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking confirmed',
            'data' => $booking,
        ]);
    }


    public function cancel(Booking $booking)
    {
        if (in_array($booking->status, [
            BookingStatus::CONFIRMED->value,
            BookingStatus::COMPLETED->value,
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Confirmed or completed booking cannot be cancelled',
            ], 422);
        }

        $booking->update([
            'status' => BookingStatus::CANCELLED->value,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking cancelled',
            'data' => $booking,
        ]);
    }

}
