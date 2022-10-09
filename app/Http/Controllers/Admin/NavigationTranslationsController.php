<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\NavigationRequest;
use App\Http\Resources\NavigationResource;
use App\Models\NavigationTranslations;
use Illuminate\Http\Request;

class NavigationTranslationsController extends Controller
{
    public function index()
    {
        $data = NavigationResource::collection(NavigationTranslations::paginate(1));
        return $data;
    }
    public function store(NavigationRequest $request)
    {
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $val->createTranslations($request->title);

        NavigationTranslations::create([
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
        $data = new NavigationResource(NavigationTranslations::findOrFail($id));
        return $data;
    }
    public function update(NavigationRequest $request, $id)
    {
        $time = NavigationTranslations::findOrFail($id);
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translations = $val->createTranslations($request->title);
        if ($val->failed) {
            return $this->failedLang();
        }
        $time->update([
            'title' => $translations
        ]);
        return response()->json(['status' => 'updated'], 201);
    }
}
