<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($booking->status !== BookingStatus::PENDING_PAYMENT->value) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not allowed for this booking',
            ], 422);
        }

        if ($booking->payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment already submitted',
            ], 422);
        }

        $request->validate([
            'proof_image' => 'required|image|max:2048',
        ]);

        $path = $request->file('proof_image')->store('payments', 'public');

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'proof_image' => $path,
            'status' => PaymentStatus::PENDING->value,
        ]);
        

        return response()->json([
            'success' => true,
            'message' => 'Payment submitted',
            'data' => $payment,
        ]);
    }

}
