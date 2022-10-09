<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Validators\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantInfoRequest;
use App\Http\Resources\RestaurantInfoResource;
use App\Models\RestaurantInfo;
use Illuminate\Http\Request;

class RestaurantInfoController extends Controller
{
    public function index()
    {
        $data = RestaurantInfoResource::collection(RestaurantInfo::paginate(1));
        return $data;
    }

    public function store(RestaurantInfoRequest $request)
    {
        if (RestaurantInfo::count() > 0) {
            return response()->json(['errors' => 'Restaurant info already exists']);
        }
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translationsText = $val->createTranslations($request->about_us_text);
        $translationsTitle = $val->createTranslations($request->about_us_title);
        $translationsIcon = $val->createTranslations($request->about_us_title);
        RestaurantInfo::create([
            'day_from' => $request->day_from,
            'day_to' => $request->day_to,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'is_open' => $request->is_open,
            'about_us_title' => $translationsTitle,
            'about_us_text' => $translationsText,
            'icon_translations' => $translationsIcon
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
        $data = new RestaurantInfoResource(RestaurantInfo::findOrFail($id));
        return $data;
    }
    public function update(RestaurantInfoRequest $request, $id)
    {
        $time = RestaurantInfo::findOrFail($id);
        $val = new Validator();
        $val->validateLang($request->sentLang);
        $translationsText = $val->createTranslations($request->about_us_text);
        $translationsTitle = $val->createTranslations($request->about_us_title);
        if ($val->failed) {
            return $this->failedLang();
        }
        $time->update([
            'day_from' => $request->day_from,
            'day_to' => $request->day_to,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to,
            'is_open' => $request->is_open,
            'about_us_title' => $translationsTitle,
            'about_us_text' => $translationsText
        ]);
        return response()->json(['status' => 'updated'], 201);
    }
}
