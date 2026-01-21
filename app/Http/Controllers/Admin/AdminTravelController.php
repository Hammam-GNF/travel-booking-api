<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use App\Services\TravelService;
use Illuminate\Http\Request;

class AdminTravelController extends Controller
{
    public function store(Request $request, TravelService $service)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
        ]);

        $travel = $service->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Travel created',
            'data' => $travel,
        ]);
    }

    public function update(Request $request, Travel $travel, TravelService $service)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'origin' => 'sometimes|string|max:100',
            'destination' => 'sometimes|string|max:100',
            'departure_date' => 'sometimes|date',
            'departure_time' => 'sometimes',
            'price' => 'sometimes|integer|min:0',
            'quota' => 'sometimes|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $travel = $service->update($travel, $data);

        return response()->json([
            'success' => true,
            'message' => 'Travel updated',
            'data' => $travel,
        ]);
    }

    public function destroy(Travel $travel, TravelService $service)
    {
        $service->deactivate($travel);

        return response()->json([
            'success' => true,
            'message' => 'Travel deactivated',
            'data' => null,
        ]);
    }
}
