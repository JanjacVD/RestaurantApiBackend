<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodCategoryRequest;
use App\Http\Requests\PaginatedRequest;
use App\Http\Resources\Menu\FoodCategoryResource;
use App\Models\Menu\FoodCategory;
use Illuminate\Http\Request;
use App\Models\Menu\FoodSection;

class FoodCategoryController extends Controller
{


    public function index(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = FoodCategoryResource::collection(FoodCategory::paginate($rpp));
        return $data;
    }

    public function getTrashed(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = FoodCategoryResource::collection(FoodCategory::onlyTrashed()->paginate($rpp));
        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodCategoryRequest $request)
    {
        $val = new Validator();
        $val->validateKeys($request->sentLang);
        $translations = $val->createTranslations($request->title);
        if ($val->failed) {
            return $this->failedLang();
        }
        $order = FoodCategory::count();
        $sectionId = FoodSection::findOrFail($request->food_section);
        FoodCategory::create([
            'title' => $translations,
            'order' => $order,
            'food_section_id' => $sectionId['id']
        ]);
        return response()->json(['status' => 'created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu\FoodSection  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = new FoodCategoryResource(FoodCategory::withTrashed()->findOrFail($id));
        return $data;
    }
    public function restore($id)
    {
        $foodCategory = FoodCategory::withTrashed()->findOrFail($id);
        $foodCategory->restore();
        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu\FoodSection  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function update(FoodCategoryRequest $request, $id)
    {
        $foodCategory = FoodCategory::findOrFail($id);
        $val = new Validator();
        $val->validateKeys($request->sentLang);
        $translations = $val->createTranslations($request->title);
        if ($val->failed) {
            return $this->failedLang();
        }
        $sectionId = FoodSection::findOrFail($request->food_section);
        $foodCategory->title = $translations;
        $foodCategory->food_section_id = $sectionId['id'];
        $foodCategory->save();
        return response()->json(['status' => 'updated'], 201);
    }
    public function updateOrder(Request $request)
    {
        $items = $request->items;
        foreach ($items as $item) {
            FoodCategory::withTrashed()->find($item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['status' => 'updated'], 201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu\FoodSection  $foodCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $foodCategory = FoodCategory::findOrFail($id);
        $foodCategory->delete();
        return response()->noContent();
    }

    public function forceDestroy($id)
    {
        FoodCategory::withTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['status' => 'Deleted'], 204);
    }
}
