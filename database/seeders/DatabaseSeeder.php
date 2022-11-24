<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Alergen;
use App\Models\Lang;
use App\Models\Menu\FoodCategory;
use App\Models\Menu\FoodItem;
use App\Models\Menu\FoodSection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Alergen::factory(5)->create();
        FoodSection::factory(5)->create();
        FoodCategory::factory(5)->create();
        FoodItem::factory(20)->create();
        $food = FoodItem::all();
        $alergen = Alergen::all()->pluck('id');
        foreach ($food as $f) {
            $f->alergen()->sync($alergen->random(2));
        }
    }
}
