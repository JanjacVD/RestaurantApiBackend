<?php

namespace App\Http\Controllers;

use App\Models\Menu\FoodCategory;
use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Menu\FoodSection;

class FoodCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = FoodCategory::all();
        return response()->json(['categories' => $categories]);
    }

    public function getTrashed()
    {
        $categories = FoodCategory::onlyTrashed()->get();
        return response()->json(['categories' => $categories]);
    }
    public function store(Request $request)
    {
        $sentLang = $request->sentLang;
        $section = FoodSection::where('id', $request->section)->first()->get('id');
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            $category = FoodCategory::make([
                'title' => [
                    $request->title,
                ],
            ]);
            $section[0]->foodCategory()->save($category);
            return response(['status' => 'Created'], 201);
        } else {
            abort(400);
        }
    }


    public function show($id)
    {
        $foodCategory = FoodCategory::withTrashed()->with('foodSection')->findOrFail($id);
        return response()->json(['categories' => $foodCategory]);
    }

    public function update(Request $request, $id)
    {
        $sentLang = $request->sentLang;
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            $foodCategory = FoodCategory::findOrFail($id);
            $foodCategory->title = $request->title;
            $foodCategory->save();
            return response(['status' => 'updated'], 202);
        } else {
            abort(400);
        }
    }

    public function restore($id)
    {
        $foodCategory = FoodCategory::withTrashed()->findOrFail($id);
        $foodCategory->restore();
        return response()->noContent();
    }
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
