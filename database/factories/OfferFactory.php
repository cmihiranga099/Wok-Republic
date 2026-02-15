<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OfferTypeEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(OfferTypeEnum::cases());
        $value = ($type === OfferTypeEnum::PERCENT) ? fake()->numberBetween(5, 50) : fake()->randomFloat(2, 5, 50);

        return [
            'code' => fake()->unique()->slug(1),
            'type' => $type->value,
            'value' => $value,
            'description' => fake()->boolean(70) ? fake()->sentence() : null,
            'min_order' => fake()->boolean(50) ? fake()->randomFloat(2, 10, 100) : null,
            'expiry_date' => fake()->dateTimeBetween('+1 week', '+1 year'),
            'status' => fake()->boolean(90),
        ];
    }
}
