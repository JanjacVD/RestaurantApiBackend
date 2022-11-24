<?php

use App\Mail\NewReservation;
use App\Models\Reservation;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Models\RestaurantInfo;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    RestaurantInfo::create(
        [
            'time_from' => "16:00",
            'time_to' => '23:00',
            'bookable_from' => "16:00",
            'bookable_to' => '20:00',
            'day_from' => 1,
            'day_to' => 6,
            'is_open' => true,
            'reservations_open' => true
        ]
    );
});
