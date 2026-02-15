<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => fake()->name(),
            'testimonial_text' => fake()->paragraph(),
            'rating' => fake()->boolean(70) ? fake()->numberBetween(1, 5) : null,
            'avatar' => fake()->boolean(50) ? fake()->imageUrl(640, 480, 'people', true) : null,
            'status' => fake()->boolean(80), // 80% chance of being approved
        ];
    }
}
