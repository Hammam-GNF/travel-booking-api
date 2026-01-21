<?php

namespace App\Http\Controllers;

use App\Models\Travel;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::where('is_active', true)
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'This is a list of travels',
            'data' => $travels,
        ]);
    }

    public function show(Travel $travel)
    {
        if (! $travel->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Travel not available',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'This is travel details',
            'data' => $travel,
        ]);
    }
}
