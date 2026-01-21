<?php

namespace App\Http\Controllers;

use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, BookingService $service)
    {
        $data = $request->validate([
            'travel_id' => 'required|exists:travels,id',
            'seats' => 'required|integer|min:1',
        ]);

        $booking = $service->create(
            $request->user()->id,
            $data['travel_id'],
            $data['seats']
        );

        return response()->json([
            'success' => true,
            'message' => 'Booking created',
            'data' => $booking,
        ]);
    }

    public function myBookings()
    {
        return response()->json([
            'success' => true,
            'message' => 'List of my bookings',
            'data' => [],
        ]);
    }
}
