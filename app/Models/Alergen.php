<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Alergen extends Model
{
    public $translatable;
    protected $fillable = ['title'];

    public function foodItem(){
        return $this->belongsToMany(FoodItem::class);
    }
    use HasTranslations, SoftDeletes;
}
