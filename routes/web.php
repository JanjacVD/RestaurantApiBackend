<?php

use App\Events\NewReservationPending;
use App\Http\Controllers\Admin\LangController;
use App\Models\Menu\FoodItem;
use App\Models\Menu\FoodSection;
use Illuminate\Support\Facades\Route;
use Spatie\Translatable\HasTranslations;

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
    return ['Laravel' => app()->version()];
});