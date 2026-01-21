<?php

namespace App\Services;

use App\Models\Travel;

class TravelService
{
    public function create(array $data): Travel
    {
        return Travel::create([
            'name' => $data['name'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_date' => $data['departure_date'],
            'departure_time' => $data['departure_time'],
            'price' => $data['price'],
            'quota' => $data['quota'],
            'available_quota' => $data['quota'],
            'is_active' => true,
        ]);
    }

    public function update(Travel $travel, array $data): Travel
    {
        $travel->update([
            'name' => $data['name'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_date' => $data['departure_date'],
            'departure_time' => $data['departure_time'],
            'price' => $data['price'],
            'is_active' => $data['is_active'] ?? $travel->is_active,
        ]);

        return $travel;
    }

    public function deactivate(Travel $travel): void
    {
        $travel->update(['is_active' => false]);
    }
}
