<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FoodSection extends Model
{
    use HasTranslations, SoftDeletes, HasFactory;

    public $translatable = ['title'];

    protected $fillable = ['title', 'order'];

}
