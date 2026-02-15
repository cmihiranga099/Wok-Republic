<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\DishImage;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // This seeder should run AFTER AddonSeeder
        $addonIds = \App\Models\Addon::all()->pluck('id');

        Dish::factory()->count(30)->create()->each(function ($dish) use ($addonIds) {
            // Create 1-3 images for each dish
            DishImage::factory()->count(rand(1, 3))->create([
                'dish_id' => $dish->id,
            ]);

            // Attach 1-5 random addons to each dish
            $dish->addons()->attach(
                $addonIds->random(rand(1, 5))->toArray()
            );
        });
    }
}
