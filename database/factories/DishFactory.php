<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $price = fake()->randomFloat(2, 5, 50);
        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'price' => $price,
            'discount_price' => fake()->boolean(30) ? fake()->randomFloat(2, 1, $price - 1) : null,
            'ingredients' => fake()->text(200),
            'allergens' => fake()->boolean(20) ? fake()->randomElement(['Peanuts', 'Gluten', 'Soy', 'Dairy']) : null,
            'veg_non_veg' => fake()->randomElement(['veg', 'non-veg', 'egg']),
            'spicy_level' => fake()->numberBetween(0, 3),
            'status' => fake()->boolean(90),
        ];
    }
}
