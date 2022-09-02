<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FoodCategory extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['title'];

    protected $fillable = ['title', 'food_section_id'];
    
    public function foodItem(){
        return $this->hasMany(FoodItem::class);
    }
    public function foodSection(){
        return $this->belongsTo(FoodSection::class)->withTrashed();
    }
}
