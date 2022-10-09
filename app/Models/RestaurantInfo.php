<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RestaurantInfo extends Model
{
    use HasFactory, HasTranslations;

    public $translations = [
        'about_us_title',
        'about_us_text',
        'icon_translations'
    ];
    protected $fillable = [
        'day_from',
        'day_to',
        'time_from',
        'time_to',
        'is_open',
        'about_us_title',
        'about_us_text',
        'icon_translations'
    ];
}
