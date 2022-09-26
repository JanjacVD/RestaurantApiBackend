<?php

namespace Database\Factories\Menu;

use App\Models\Menu\FoodCategory;
use App\Models\Menu\FoodItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FoodItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ['en' => $this->faker->word(), 'hr' => $this->faker->word()],
            'description' => ['en' => $this->faker->word(), 'hr' => $this->faker->word()],
            'created_at' => now(),
            'deleted_at' => null,
            'updated_at' => now(),
            'price' => 19.99,
            'food_category_id' => FoodCategory::all()->pluck('id')->random(),
            'order' => (count(FoodItem::all()) + 1)
        ];
    }
}
