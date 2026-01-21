<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminTravelController extends Controller
{
    public function store(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Travel created',
            'data' => [],
        ]);
    }
}
