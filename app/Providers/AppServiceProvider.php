<?php

namespace App\Providers;

use App\Models\Menu\FoodCategory;
use App\Models\Menu\FoodItem;
use App\Models\Menu\FoodSection;
use App\Observers\FoodCategoryObserver;
use App\Observers\FoodItemObserver;
use App\Observers\FoodSectionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FoodSection::observe(FoodSectionObserver::class);
        FoodCategory::observe(FoodCategoryObserver::class);
        FoodItem::observe(FoodItemObserver::class);
    }
}
