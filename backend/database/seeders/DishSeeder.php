<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // make sure we have ingredients
        $ingredients = Ingredient::all();

        Dish::factory(10)->create()->each(function ($dish) use ($ingredients) {
            // pick 3–6 random ingredients
            $randomIngredients = $ingredients->random(rand(3, 6));

            $pivotData = [];
            foreach ($randomIngredients as $ingredient) {
                $pivotData[$ingredient->id] = [
                    'quantity' => fake()->numberBetween(1, 5),
                ];
            }

            $dish->ingredients()->attach($pivotData);
        });
    }
}
