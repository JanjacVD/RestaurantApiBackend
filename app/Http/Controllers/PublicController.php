<?php

namespace App\Http\Controllers;

use App\Models\Menu\FoodSection;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function menu(){
        $menu = FoodSection::with(['foodCategory', 'foodCategory.foodItem', 'foodCategory.foodItem.alergen'])->get();
        return response()->json(['menu' => $menu]);
    }
}
