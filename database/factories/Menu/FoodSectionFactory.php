<?php

namespace Database\Factories\Menu;

use App\Models\Menu\FoodSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FoodSectionFactory extends Factory
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
            'order' => (count(FoodSection::all()) + 1)
        ];
    }
}
