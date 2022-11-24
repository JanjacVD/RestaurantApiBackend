<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisabledDateRequest;
use App\Http\Resources\DisabledDateResource;
use App\Models\DisabledDates;
use Illuminate\Http\Request;

class DisabledDatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dates = DisabledDates::all();
        return DisabledDateResource::collection($dates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DisabledDateRequest $request)
    {
        $date = $request->date;
        DisabledDates::create([
            'date' => $date
        ]);
        return $this->successResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DiabledDates  $diabledDates
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $date = DisabledDates::findOrFail($id);
        return new DisabledDateResource($date);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DiabledDates  $diabledDates
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $date = DisabledDates::findOrFail($id);
        $date->delete();
        return response()->noContent();
    }
}
