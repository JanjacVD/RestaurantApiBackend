<?php

namespace App\Observers;

use App\Models\Menu\FoodCategory;
use Illuminate\Support\Facades\Cache;

class FoodCategoryObserver
{
    /**
     * Handle the FoodCategory "created" event.
     *
     * @param  \App\Models\FoodCategory  $foodCategory
     * @return void
     */
    public function created(FoodCategory $foodCategory)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodCategory "updated" event.
     *
     * @param  \App\Models\FoodCategory  $foodCategory
     * @return void
     */
    public function updated(FoodCategory $foodCategory)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodCategory "deleted" event.
     *
     * @param  \App\Models\FoodCategory  $foodCategory
     * @return void
     */
    public function deleted(FoodCategory $foodCategory)
    {
        $foodCategory->foodItem()->delete();
        Cache::forget('menu');
    }

    /**
     * Handle the FoodCategory "restored" event.
     *
     * @param  \App\Models\FoodCategory  $foodCategory
     * @return void
     */
    public function restored(FoodCategory $foodCategory)
    {
        $foodCategory->foodItem()->restore();
        Cache::forget('menu');
    }

    /**
     * Handle the FoodCategory "force deleted" event.
     *
     * @param  \App\Models\FoodCategory  $foodCategory
     * @return void
     */
    public function forceDeleted(FoodCategory $foodCategory)
    {
        $foodCategory->foodItem()->forceDelete();
        Cache::forget('menu');
    }
}
