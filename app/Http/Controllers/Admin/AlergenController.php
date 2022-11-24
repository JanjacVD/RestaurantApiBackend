<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlergenRequest;
use App\Http\Requests\PaginatedRequest;
use App\Http\Resources\Menu\AlergenResource;
use App\Models\Alergen;
use Illuminate\Http\Request;

class AlergenController extends Controller
{
    public function index(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = AlergenResource::collection(Alergen::paginate($rpp));
        return $data;
    }

    public function getTrashed(PaginatedRequest $request)
    {
        $rpp = $request->rpp;
        $data = AlergenResource::collection(Alergen::onlyTrashed()->paginate($rpp));
        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlergenRequest $request)
    {
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $request->title;
        if ($val->failed) {
            return $this->failedLang();
        }
        Alergen::create([
            'title' => $translations,
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
        $data = new AlergenResource(Alergen::withTrashed()->findOrFail($id));
        return $data;
    }
    public function restore($id)
    {
        $alergen = Alergen::withTrashed()->findOrFail($id);
        $alergen->restore();
        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu\FoodSection  $foodSection
     * @return \Illuminate\Http\Response
     */
    public function update(AlergenRequest $request, $id)
    {
        $alergen = Alergen::findOrFail($id);
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $request->title;
        if ($val->failed) {
            return $this->failedLang();
        }
        $alergen->title = $translations;
        $alergen->save();
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
        $alergen = Alergen::findOrFail($id);
        $alergen->delete();
        return response()->noContent();
    }

    public function forceDestroy($id)
    {
        Alergen::withTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['status' => 'Deleted'], 204);
    }
}
