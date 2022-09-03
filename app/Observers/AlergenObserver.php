<?php

namespace App\Observers;

use App\Models\Alergen;
use Illuminate\Support\Facades\Cache;

class AlergenObserver
{
    /**
     * Handle the Alergen "created" event.
     *
     * @param  \App\Models\Alergen  $alergen
     * @return void
     */


    /**
     * Handle the Alergen "updated" event.
     *
     * @param  \App\Models\Alergen  $alergen
     * @return void
     */
    public function updated(Alergen $alergen)
    {
        Cache::forget('menu');
    }

    /**
     * Handle the Alergen "deleted" event.
     *
     * @param  \App\Models\Alergen  $alergen
     * @return void
     */
    public function deleted(Alergen $alergen)
    {
        Cache::forget('menu');
        $alergen->foodItem()->detach();
    }

    /**
     * Handle the Alergen "restored" event.
     *
     * @param  \App\Models\Alergen  $alergen
     * @return void
     */


    /**
     * Handle the Alergen "force deleted" event.
     *
     * @param  \App\Models\Alergen  $alergen
     * @return void
     */
    public function forceDeleted(Alergen $alergen)
    {
        Cache::forget('menu');
        $alergen->foodItem()->detach();
    }
}
