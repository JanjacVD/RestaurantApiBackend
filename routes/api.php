<?php

use App\Http\Controllers\Admin\FoodCategoryController;
use App\Http\Controllers\Admin\FoodItemController;
use App\Http\Controllers\Admin\AlergenController;
use App\Http\Controllers\Admin\DisabledDatesController;
use App\Http\Controllers\Admin\FoodSectionController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Guest\PublicController;
use App\Models\Menu\FoodSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('menu', [PublicController::class, 'menu']);
Route::get('info', [PublicController::class, 'workTime']);
Route::get('dates', [PublicController::class, 'disabledDates']);
Route::post('times', [PublicController::class, 'disabledTimes']);
Route::post('reservation-make', [PublicController::class, 'reservationMake']);
Route::post('reservation-confirm', [PublicController::class, 'reservationConfirm']);
Route::delete('reservation-cancel', [PublicController::class, 'reservationCancel']);
Route::middleware(['throttle:contact'])->post('contact', [PublicController::class, 'contact']);
//429
//TODO:: SCHEDULED COMMAND THAT DELETES OLD RESERVATIONS OLD PENDINGS
//TODO: Routes for storing and deleting users
Route::group(['middleware' => ['auth:sanctum', 'mustBeAdmin']], function () {
    //Section for admin
    Route::get('section', [FoodSectionController::class, 'index']);
    Route::get('section-trashed', [FoodSectionController::class, 'getTrashed']);
    Route::get('section-show/{sectionId}', [FoodSectionController::class, 'show']);
    Route::get('section-restore/{sectionId}', [FoodSectionController::class, 'restore']);
    Route::post('section-new', [FoodSectionController::class, 'store']);
    Route::put('section-update/{sectionId}', [FoodSectionController::class, 'update']);
    Route::delete('section-delete/{sectionId}', [FoodSectionController::class, 'destroy']);
    Route::delete('section-destroy/{sectionId}', [FoodSectionController::class, 'forceDestroy']);
    //Category for admin
    Route::get('category', [FoodCategoryController::class, 'index']);
    Route::get('category-trashed', [FoodCategoryController::class, 'getTrashed']);
    Route::get('category-show/{categoryId}', [FoodCategoryController::class, 'show']);
    Route::get('category-restore/{categoryId}', [FoodCategoryController::class, 'restore']);
    Route::post('category-new', [FoodCategoryController::class, 'store']);
    Route::put('category-update/{categoryId}', [FoodCategoryController::class, 'update']);
    Route::delete('category-delete/{categoryId}', [FoodCategoryController::class, 'destroy']);
    Route::delete('category-destroy/{categoryId}', [FoodCategoryController::class, 'forceDestroy']);
    //Food items for admin
    Route::get('food-item', [FoodItemController::class, 'index']);
    Route::get('food-item-trashed', [FoodItemController::class, 'getTrashed']);
    Route::get('food-item-show/{categoryId}', [FoodItemController::class, 'show']);
    Route::get('food-item-restore/{categoryId}', [FoodItemController::class, 'restore']);
    Route::post('food-item-new', [FoodItemController::class, 'store']);
    Route::put('food-item-update/{categoryId}', [FoodItemController::class, 'update']);
    Route::delete('food-item-delete/{categoryId}', [FoodItemController::class, 'destroy']);
    Route::delete('food-item-destroy/{categoryId}', [FoodItemController::class, 'forceDestroy']);
    //Alergen items for admin
    Route::get('alergen', [AlergenController::class, 'index']);
    Route::get('alergen-trashed', [AlergenController::class, 'getTrashed']);
    Route::get('alergen-show/{categoryId}', [AlergenController::class, 'show']);
    Route::get('alergen-restore/{categoryId}', [AlergenController::class, 'restore']);
    Route::post('alergen-new', [AlergenController::class, 'store']);
    Route::put('alergen-update/{categoryId}', [AlergenController::class, 'update']);
    Route::delete('alergen-delete/{categoryId}', [AlergenController::class, 'destroy']);
    Route::delete('alergen-destroy/{categoryId}', [AlergenController::class, 'forceDestroy']);
    //Settings for admin
    Route::get('disabled-date', [DisabledDatesController::class, 'index']);
    Route::get('disabled-date/{dateId}', [DisabledDatesController::class, 'show']);
    Route::post('disabled-date', [DisabledDatesController::class, 'store']);
    Route::delete('disabled-date/{dateId}', [DisabledDatesController::class, 'destroy']);
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('reservations/{reservationUuid}', [ReservationController::class, 'show']);
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::delete('reservations/{reservationUuid}', [ReservationController::class, 'destroy']);
});
require __DIR__ . '/auth.php';
