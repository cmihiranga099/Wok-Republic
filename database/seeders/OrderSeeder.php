<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;
use App\Models\Addon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dishes = Dish::all();
        $allAddons = Addon::all();

        Order::factory()->count(10)->create()->each(function ($order) use ($dishes, $allAddons) {
            $orderSubtotal = 0;
            // Create 1-5 order items for each order
            OrderItem::factory()->count(rand(1, 5))->make()->each(function ($orderItem) use ($order, $dishes, $allAddons, &$orderSubtotal) {
                // Assign an order_id
                $orderItem->order_id = $order->id;

                // Assign a random dish or keep dish_id null
                if ($dishes->isNotEmpty() && rand(0, 1)) { // 50% chance to link to an existing dish
                    $dish = $dishes->random();
                    $orderItem->dish_id = $dish->id;
                    $orderItem->dish_name = $dish->name;
                    $orderItem->price = $dish->price;
                } else {
                    $orderItem->dish_id = null;
                    $orderItem->dish_name = \Faker\Factory::create()->words(2, true);
                    $orderItem->price = \Faker\Factory::create()->randomFloat(2, 5, 30);
                }

                $orderItem->quantity = \Faker\Factory::create()->numberBetween(1, 3);
                $itemTotal = $orderItem->price * $orderItem->quantity;
                $orderItem->total = $itemTotal;
                $orderItem->save();

                $orderSubtotal += $itemTotal;

                // Attach 0-2 addons to each order item
                if ($allAddons->isNotEmpty()) {
                    $addonsToAttach = $allAddons->random(rand(0, min(2, $allAddons->count())));
                    foreach ($addonsToAttach as $addon) {
                        $orderItem->addons()->create([
                            'order_item_id' => $orderItem->id,
                            'addon_name' => $addon->name,
                            'addon_price' => $addon->price,
                        ]);
                        $orderSubtotal += $addon->price * $orderItem->quantity;
                    }
                }
            });

            // Update order totals based on created items and addons
            $order->subtotal = $orderSubtotal;
            $order->total = $orderSubtotal + $order->delivery_fee;
            $order->save();
        });
    }
}
