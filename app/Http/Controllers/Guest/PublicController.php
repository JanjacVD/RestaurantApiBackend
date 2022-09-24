<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Resources\Menu\FoodSectionResource;
use App\Models\Lang;
use App\Models\Menu\FoodSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    public function menu(Request $request)
    {
        $validate = Validator::make(
            $request->only('lang'),
            [
                'lang' => ['string']
            ]
        );
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }
   
        $menu = Cache::rememberForever('menu', function () {
            $query = FoodSection::with('foodCategory', 'foodCategory.foodItem', 'foodCategory.foodItem.alergen')->get();
            $data = FoodSectionResource::collection($query);
            return $data;
        });
        return $menu;
    }
}
