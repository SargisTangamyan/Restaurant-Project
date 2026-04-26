<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    protected $model = Dish::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'slug'          => Str::slug($name),
            'category_id'   => Category::inRandomOrder()->first()->id ?? Category::factory(),
            'restaurant_id' => Restaurant::inRandomOrder()->first()->id ?? Restaurant::factory(),
            'name'          => $name,
            'description'   => fake()->sentence(10),
            'price'         => fake()->randomFloat(2, 2, 100),
            'image'         => $this->faker->imageUrl(640, 480, 'food', true, 'dish'),
            'is_available'  => true,
        ];
    }
}