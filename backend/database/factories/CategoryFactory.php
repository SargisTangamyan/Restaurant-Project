<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => ucfirst($name),
            'parent_id' => null, // default to top-level
        ];
    }

    /**
     * Optional: state for subcategory
     */
    public function child(Category $parent): static
    {
        return $this->state([
            'parent_id' => $parent->id,
        ]);
    }
}
