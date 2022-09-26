<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodSectionRequest;
use App\Http\Requests\PaginatedRequest;
use App\Http\Resources\Menu\FoodSectionResource;
use App\Models\Menu\FoodSection;
use Illuminate\Http\Request;

class FoodSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = FoodSectionResource::collection(FoodSection::paginate($rpp));
        return $data;
    }

    public function getTrashed(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = FoodSectionResource::collection(FoodSection::onlyTrashed()->paginate($rpp));
        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodSectionRequest $request)
    {
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $val->createTranslations($request->title);
        if ($val->failed) {
            return $this->failedLang();
        }
        $order = FoodSection::count();
        FoodSection::create([
            'title' => $translations,
            'order' => $order
        ]);
        return response()->json(['status' => 'created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu\FoodSection  $foodSection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = new FoodSectionResource(FoodSection::withTrashed()->findOrFail($id));
        return $data;
    }
    public function restore($id)
    {
        $foodSection = FoodSection::withTrashed()->findOrFail($id);
        $foodSection->restore();
        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu\FoodSection  $foodSection
     * @return \Illuminate\Http\Response
     */
    public function update(FoodSectionRequest $request, $id)
    {
        $foodSection = FoodSection::findOrFail($id);
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $val->createTranslations($request->title);
        if ($val->failed) {
            return $this->failedLang();
        }
        $foodSection->title = $translations;
        $foodSection->save();
        return response()->json(['status' => 'updated'], 201);
    }
    public function updateOrder(Request $request)
    {
        $items = $request->items;
        foreach ($items as $item) {
            FoodSection::withTrashed()->find($item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['status' => 'updated'], 201);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu\FoodSection  $foodSection
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $foodSection = FoodSection::findOrFail($id);
        $foodSection->delete();
        return response()->noContent();
    }

    public function forceDestroy($id)
    {
        FoodSection::withTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['status' => 'Deleted'], 204);
    }
}
