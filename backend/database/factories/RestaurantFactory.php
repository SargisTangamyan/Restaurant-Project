<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RestaurantFactory extends Factory
{
    protected $model = Restaurant::class;

    public function definition(): array
    {
        static $names = [
            'Saffron & Smoke',
            'Olive Alley Kitchen',
            'Copper Spoon Noodle Bar',
            'The Green Lantern Bistro',
            'Basil & Brick Oven',
            'Riverstone Tap & Table',
        ];

        static $imageIndex = 1;

        $image = $imageIndex <= 6 ? 'images/original/' . $imageIndex. '.jpg' : null;

        $imageIndex++;

        $name = array_shift($names) ?? $this->faker->unique()->company();

        return [
            'owner_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(12),
            'image' => $image,
            'phone_number' => $this->faker->phoneNumber(),
            'rating' => $this->faker->randomFloat(1, 3, 5),
        ];
    }
}
