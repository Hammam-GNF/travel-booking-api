<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'travel_id',
        'seats',
        'total_price',
        'status',
        'paid_at',
        'confirmed_at',
        'completed_at',
        'cancelled_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
