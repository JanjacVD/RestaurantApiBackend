<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_from',
        'day_to',
        'time_from',
        'time_to',
        'bookable_from',
        'bookable_to',
        'is_open',
        'reservations_open',
    ];
}
