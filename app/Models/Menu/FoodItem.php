<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FoodItem extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['title', 'description', 'alergens'];

    protected $fillable = ['title', 'description', 'alergens', 'price'];


    public function foodCategory(){
        return $this->belongsTo(FoodCategory::class);
    }
}
