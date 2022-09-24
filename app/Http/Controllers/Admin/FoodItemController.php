<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodItemRequest;
use App\Http\Requests\PaginatedRequest;
use App\Http\Resources\Menu\FoodItemResource;
use App\Models\Alergen;
use App\Models\Lang;
use App\Models\Menu\FoodCategory;
use App\Models\Menu\FoodItem;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{

    public function index(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = FoodItemResource::collection(FoodItem::paginate($rpp));
        return $data;
    }

    public function getTrashed(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = FoodItemResource::collection(FoodItem::onlyTrashed()->paginate($rpp));
        return $data;
    }


    public function store(FoodItemRequest $request)
    {
        $sentLang = $request->sentLang;
        $category = FoodCategory::where('id', $request->category)->first()->get('id');
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            $foodItem = FoodItem::make([
                'title' => [
                    $request->title,
                ],
                'description' => [
                    $request->description
                ],
                'price' => $request->price,
            ]);
            $category[0]->foodItem()->save($foodItem);
            if ($request->alergen != null) {
                $alergens = Alergen::whereIn('id', $request->alergen)->pluck('id');
                $foodItem->alergen()->sync($alergens);
            }
            return response(['status' => 'Created'], 201);
        } else {
            abort(400);
        }
    }

    public function show($id)
    {
        $foodCategory = FoodCategory::all();
        $alergens = Alergen::all();
        $foodItem = FoodItem::with('alergen')->findOrFail($id);
        return response()->json(['items' => $foodItem, 'categories' => $foodCategory]);
    }

    public function update(FoodItemRequest $request, $id)
    {
        $sentLang = $request->sentLang;
        $category = FoodCategory::where('id', $request->category)->first()->get('id');
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            $foodItem = FoodItem::findOrFail($id);
            $foodItem->title = $request->title;
            $foodItem->description = $request->description;
            $foodItem->price = $request->price;
            if ($request->alergen != null) {
                $alergens = Alergen::whereIn('id', $request->alergen)->pluck('id');
                $foodItem->alergen()->sync($alergens);
            }
            $foodItem->save();
            $category[0]->foodItem()->save($foodItem);
            return response(['status' => 'Updated'], 202);
        } else {
            abort(403);
        }
    }

    public function destroy($id)
    {
        $foodItem = FoodItem::findOrFail($id);
        $foodItem->delete();
        return response()->noContent();
    }

    public function forceDelete($id)
    {
        FoodItem::withTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['status' => 'Deleted'], 204);
    }
}