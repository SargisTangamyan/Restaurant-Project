<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    protected $model = Dish::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 2, 100),
            'image'       => $this->faker->imageUrl(640, 480, 'food', true, 'dish'),
        ];
    }
}
