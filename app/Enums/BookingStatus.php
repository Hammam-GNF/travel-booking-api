<?php

namespace App\Enums;

enum BookingStatus: string
{
    case PENDING_PAYMENT = 'PENDING_PAYMENT';
    case PAID = 'PAID';
    case CONFIRMED = 'CONFIRMED';
    case COMPLETED = 'COMPLETED';
    case CANCELLED = 'CANCELLED';
}
