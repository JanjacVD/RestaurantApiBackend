<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = Reservation::where('confirmed', true)->get();
        return ReservationResource::collection($res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            Reservation::create([
                'uuid' => Str::uuid(),
                'name' => $request->name,
                'numOfPeople' => $request->numOfPeople,
                'phone' => $request->phone,
                'reservation_datetime' => $request->reservation_datetime,
                'email' => $request->email,
                'confirmed' => true
            ]);
        return response()->json(['status' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    { 
        $uuid = $request->uuid;
        $reservation = Reservation::where('uuid', $uuid)->get();
        return new ReservationResource($reservation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $uuid = $request->uuid;
        Reservation::where('uuid', $uuid)->delete();
        return response()->noContent();
    }
}
