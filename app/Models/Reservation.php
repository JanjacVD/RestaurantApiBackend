<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'numOfPeople',
        'reservation_datetime',
        'email',
        'phone',
        'confirmed'
    ];
    protected $hidden = [
        'id',
    ];
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    public function scopeBookedTimes(Builder $query, $date, $maxReservationsPerTimePeriod)
    {
        return static::whereDate('reservation_datetime', $date)
            ->where('confirmed', true)
            ->groupBy('reservation_datetime')
            ->havingRaw('count(*) >= ?', [$maxReservationsPerTimePeriod])->pluck('reservation_datetime')->toArray();
    }
    public function scopeBookedDates(Builder $query, $maxReservationsPerDay)
    {
        return static::selectRaw('CAST(reservation_datetime as DATE) as date')
            ->where('confirmed', true)
            ->groupBy('date')
            ->havingRaw('count(date) >= ?', [$maxReservationsPerDay])->pluck('date')->toArray();
    }
}
