<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Messages extends Model
{
    use HasFactory, HasTranslations;

    public $translations = [
        'title'
    ];
    protected $fillable = [
        'title', 'message'
    ];
}
