<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 5, 50);
        $quantity = fake()->numberBetween(1, 3);
        return [
            'order_id' => Order::factory(),
            'dish_id' => fake()->boolean(90) ? Dish::factory() : null, // 90% chance of linking to a dish
            'dish_name' => fake()->words(2, true),
            'price' => $price,
            'quantity' => $quantity,
            'total' => $price * $quantity,
        ];
    }
}
