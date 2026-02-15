<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ReservationStatusEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->boolean(50) ? User::factory() : null,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'reservation_date' => fake()->dateTimeBetween('now', '+1 year'),
            'number_of_guests' => fake()->numberBetween(1, 10),
            'table_number' => fake()->boolean(70) ? fake()->randomNumber(2, false) : null,
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
            'status' => fake()->randomElement(ReservationStatusEnum::cases())->value,
        ];
    }
}
