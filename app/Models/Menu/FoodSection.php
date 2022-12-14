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

    public function foodCategory()
    {
        return $this->hasMany(FoodCategory::class);
    }
    public function foodItem()
    {
        return $this->hasManyThrough(FoodItem::class, FoodCategory::class);
    }
}
