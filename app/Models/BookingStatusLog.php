<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;

class BookingStatusLog extends Model
{
    protected $table = 'booking_status_logs';

    protected $casts = [
        'status' => BookingStatus::class,
    ];

}
