<?php

namespace App\Observers;

use App\Models\Menu\FoodSection;
use Illuminate\Support\Facades\Cache;

class FoodSectionObserver
{
    /**
     * Handle the FoodSection "created" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function created(FoodSection $foodSection)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodSection "updated" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function updated(FoodSection $foodSection)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the FoodSection "deleted" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function deleted(FoodSection $foodSection)
    {
        $foodSection->foodCategory()->delete();
        Cache::forget('menu');
    }

    /**
     * Handle the FoodSection "restored" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function restored(FoodSection $foodSection)
    {
        $foodSection->foodCategory()->restore();
        Cache::forget('menu');
    }

    /**
     * Handle the FoodSection "force deleted" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function forceDeleted(FoodSection $foodSection)
    {
        $foodSection->foodCategory()->forceDelete();
        Cache::forget('menu');
    }
}
