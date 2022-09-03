<?php

namespace App\Http\Controllers;

use App\Models\Menu\FoodSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PublicController extends Controller
{
    public function menu(){
        
        $menu = Cache::rememberForever('menuItems', function(){
        return FoodSection::with(['foodCategory', 'foodCategory.foodItem', 'foodCategory.foodItem.alergen'])->get();
        });
        return response()->json(['menu' => $menu]);
    }
}
