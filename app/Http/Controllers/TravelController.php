<?php

namespace App\Http\Controllers;

use App\Models\Travel;

class TravelController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'This is a list of travels',
            'data' => Travel::where('is_active', true)->get(),
        ]);
    }

    public function show(Travel $travel)
    {
        if (! $travel->is_active) {
            abort(404);
        }

        return response()->json([
            'success' => true,
            'message' => '',
            'data' => $travel,
        ]);
    }
}
