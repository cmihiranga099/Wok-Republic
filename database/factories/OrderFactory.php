<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderPaymentStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\OrderDeliveryPickupEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 10, 100);
        $deliveryFee = fake()->randomFloat(2, 0, 5);
        $total = $subtotal + $deliveryFee;

        return [
            'user_id' => fake()->boolean(70) ? User::factory() : null, // 70% chance of having a user
            'order_code' => 'WR-' . fake()->unique()->randomNumber(6, true), // Wok Republic order code
            'customer_name' => fake()->name(),
            'customer_email' => fake()->unique()->safeEmail(),
            'customer_phone' => fake()->phoneNumber(),
            'delivery_address' => fake()->boolean(80) ? fake()->address() : null,
            'delivery_fee' => $deliveryFee,
            'subtotal' => $subtotal,
            'total' => $total,
            'payment_method' => fake()->randomElement(['cod', 'card']),
            'payment_status' => fake()->randomElement(OrderPaymentStatusEnum::cases())->value,
            'order_status' => fake()->randomElement(OrderStatusEnum::cases())->value,
            'delivery_pickup' => fake()->randomElement(OrderDeliveryPickupEnum::cases())->value,
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
