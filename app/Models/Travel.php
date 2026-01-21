<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travel';

    protected $fillable = [
        'name',
        'origin',
        'destination',
        'departure_date',
        'departure_time',
        'price',
        'quota',
        'available_quota',
        'is_active',
    ];
}
