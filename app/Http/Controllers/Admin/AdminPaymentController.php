<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function verify(Request $request, Payment $payment)
    {
        if ($payment->status !== PaymentStatus::PENDING->value) {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed',
            ], 422);
        }

        $payment->update([
            'status' => PaymentStatus::VERIFIED->value,
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        $payment->booking->update([
            'status' => BookingStatus::PAID->value,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified',
        ]);
    }

    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== PaymentStatus::PENDING->value) {
            return response()->json([
                'success' => false,
                'message' => 'Payment already processed',
            ], 422);
        }

        $payment->update([
            'status' => PaymentStatus::REJECTED->value,
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment rejected',
        ]);
    }

}
