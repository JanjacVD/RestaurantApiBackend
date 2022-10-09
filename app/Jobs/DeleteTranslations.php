<?php

namespace App\Jobs;

use App\Models\Alergen;
use App\Models\Lang;
use App\Models\Menu\FoodCategory;
use App\Models\Menu\FoodItem;
use App\Models\Menu\FoodSection;
use App\Models\Messages;
use App\Models\NavigationTranslations;
use App\Models\RestaurantInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteTranslations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $langCode;
    public function __construct($langCode)
    {
        $this->langCode = $langCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $foodItems = FoodItem::all();
        $foodCategories = FoodCategory::all();
        $foodSection = FoodSection::all();
        $alergen = Alergen::all();
        $messages = Messages::all();
        $info = RestaurantInfo::all();
        $nav = NavigationTranslations::all();
        foreach ($foodItems as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
        foreach ($foodCategories as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
        foreach ($foodSection as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
        foreach ($alergen as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
        foreach ($messages as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
        foreach ($info as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
        foreach ($nav as $f) {
            $f->forgetAllTranslations($this->langCode);
            $f->save();
        }
    }
}
