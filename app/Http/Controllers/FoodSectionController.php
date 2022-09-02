<?php

namespace App\Http\Controllers;

use App\Models\Lang;
use App\Models\Menu\FoodSection;
use Illuminate\Http\Request;

class FoodSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = FoodSection::all();
        return response()->json(['sections' => $sections]);
    }

    public function getTrashed()
    {
        $sections = FoodSection::onlyTrashed()->get();
        return response()->json(['sections' => $sections]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sentLang = $request->sentLang;
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            FoodSection::create([
                'title' => [
                    $request->title
                ]
            ]);
            return response(['status' => 'Created'], 201);
        } else {
            abort(400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu\FoodSection  $foodSection
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $foodSection = FoodSection::withTrashed()->findOrFail($id);
        return response()->json(['sections' => $foodSection]);
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
    public function update(Request $request, $id)
    {
        $sentLang = $request->sentLang;
        $langs = Lang::whereIn('lang', $sentLang)->pluck('lang');
        if ($langs = $sentLang) {
            $foodSection = FoodSection::findOrFail($id);
            $foodSection->title = $request->title;
            $foodSection->save();
            return response(['status' => 'updated'],202);
        } else {
            abort(400);
        }
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
