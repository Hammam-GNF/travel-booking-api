<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminBookingController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'List of all bookings for admin',
            'data' => [],
        ]);
    }
}
