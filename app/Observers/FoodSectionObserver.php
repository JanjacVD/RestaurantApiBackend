<?php

namespace App\Observers;

use App\Models\Menu\FoodSection;

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
        
    }

    /**
     * Handle the FoodSection "updated" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function updated(FoodSection $foodSection)
    {
        //
    }

    /**
     * Handle the FoodSection "deleted" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function deleted(FoodSection $foodSection)
    {
        //
    }

    /**
     * Handle the FoodSection "restored" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function restored(FoodSection $foodSection)
    {
        //
    }

    /**
     * Handle the FoodSection "force deleted" event.
     *
     * @param  \App\Models\FoodSection  $foodSection
     * @return void
     */
    public function forceDeleted(FoodSection $foodSection)
    {
        //
    }
}
