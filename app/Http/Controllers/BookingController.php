<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Booking created',
            'data' => [],
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
