<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
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
        $val = new Validator();
        $val->validateLang($request->sentLang);
        if ($val->failed) {
            return $this->failedLang();
        }
        $translationsTitle = $val->createTranslations($request->title);
        $translationsDesc = $val->createTranslations($request->description);
        $alergen = $request->alergen;
        if ($alergen === null) {
            $alergen = [];
        }
        $val->validateAlergen($alergen);
        if ($val->failed) {
            return $this->failedAlergen();
        }
        $order = FoodItem::count();
        $categoryId = FoodCategory::findOrFail($request->food_category);

        $item = FoodItem::create([
            'title' => $translationsTitle,
            'description' => $translationsDesc,
            'order' => $order,
            'price' => $request->price,
            'food_category_id' => $categoryId['id']
        ]);
        $item->alergen()->sync($alergen);
        return response()->json(['status' => 'created'], 201);
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
        $val = new Validator();
        $val->validateLang($request->sentLang);
        if ($val->failed) {
            return $this->failedLang();
        }
        $translationsTitle = $val->createTranslations($request->title);
        $translationsDesc = $val->createTranslations($request->description);
        $alergen = $request->alergen;
        $val->validateAlergen($alergen);
        if ($val->failed) {
            return $this->failedAlergen();
        }
        $order = FoodItem::count();
        $categoryId = FoodCategory::findOrFail($request->food_category);

        $item = FoodItem::findOrFail($id)->update([
            'title' => $translationsTitle,
            'description' => $translationsDesc,
            'order' => $order,
            'price' => $request->price,
            'food_category_id' => $categoryId['id']
        ]);
        $item->alergen()->sync($alergen);
        return response()->json(['status' => 'updated'], 201);
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
