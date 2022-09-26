<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    protected $fillable = [
        'lang_name',
        'lang_code'
    ];
    use HasFactory;
}
