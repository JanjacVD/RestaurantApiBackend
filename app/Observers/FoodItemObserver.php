<?php

namespace App\Observers;

use App\Models\Menu\FoodItem;
use Illuminate\Support\Facades\Cache;

class FoodItemObserver
{
    /**
     * Handle the FoodItem "created" event.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return void
     */
    public function created(FoodItem $foodItem)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodItem "updated" event.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return void
     */
    public function updated(FoodItem $foodItem)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodItem "deleted" event.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return void
     */
    public function deleted(FoodItem $foodItem)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodItem "restored" event.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return void
     */
    public function restored(FoodItem $foodItem)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodItem "force deleted" event.
     *
     * @param  \App\Models\FoodItem  $foodItem
     * @return void
     */
    public function forceDeleted(FoodItem $foodItem)
    {
        Cache::forget('menu');
        $foodItem->alergen()->detach();
    }
}
