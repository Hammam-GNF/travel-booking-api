<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'proof_image',
        'status',
        'verified_by',
        'verified_at',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
