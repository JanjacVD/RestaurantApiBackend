<?php

namespace App\Models\Menu;

use App\Models\Alergen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FoodItem extends Model
{
    use SoftDeletes, HasTranslations, HasFactory;

    public $translatable = ['title', 'description'];

    protected $fillable = ['title', 'description', 'price', 'order', 'food_category_id'];


    public function foodCategory()
    {
        return $this->belongsTo(FoodCategory::class);
    }

    public function alergen()
    {
        return $this->belongsToMany(Alergen::class);
    }
}
