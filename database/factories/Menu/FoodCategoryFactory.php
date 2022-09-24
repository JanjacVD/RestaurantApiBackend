<?php

namespace Database\Factories\Menu;

use App\Models\Menu\FoodCategory;
use App\Models\Menu\FoodSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FoodCategoryFactory extends Factory
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
            'created_at' => now(),
            'deleted_at' => null,
            'updated_at' => now(),
            'food_section_id' => FoodSection::all()->pluck('id')->random(),
            'order' => (count(FoodCategory::all()) + 1)
        ];
    }
}
