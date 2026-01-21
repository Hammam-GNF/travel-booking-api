<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Travel;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingService
{
    public function create(int $userId, int $travelId, int $seats): Booking
    {
        return DB::transaction(function () use ($userId, $travelId, $seats) {

            $travel = Travel::where('id', $travelId)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();

            if (! $travel) {
                throw new Exception('Travel not available', 404);
            }

            if ($travel->available_quota < $seats) {
                throw new Exception('Insufficient quota', 422);
            }

            $booking = Booking::create([
                'user_id' => $userId,
                'travel_id' => $travelId,
                'seats' => $seats,
                'total_price' => $travel->price * $seats,
                'status' => 'PENDING_PAYMENT',
            ]);

            $travel->decrement('available_quota', $seats);

            return $booking;
        });
    }

    public function cancel(Booking $booking, int $actorId, string $actorType)
    {
        if ($booking->status !== 'PENDING_PAYMENT') {
            throw new Exception('Cannot cancel this booking', 409);
        }

        DB::transaction(function () use ($booking) {

            $booking->update([
                'status' => 'CANCELLED',
                'cancelled_at' => now(),
            ]);

            $booking->travel()->lockForUpdate()->increment(
                'available_quota',
                $booking->seats
            );
        });
    }

}
