<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Alergen extends Model
{
    use HasTranslations, SoftDeletes;

    public $translatable = ['title'];
    protected $fillable = ['title'];
    protected $hidden = ['pivot'];

    public function foodItem(){
        return $this->belongsToMany(FoodItem::class);
    }
}
