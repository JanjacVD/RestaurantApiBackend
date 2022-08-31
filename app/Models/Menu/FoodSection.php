<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FoodSection extends Model
{
    use HasTranslations, SoftDeletes;

    public $translatable = ['title'];

    protected $fillable = ['title'];

    public function foodCategory(){
        return $this->hasMany(FoodCategory::class);
    }
}
