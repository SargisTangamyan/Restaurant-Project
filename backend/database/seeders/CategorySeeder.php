<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create top-level categories
        $parents = Category::factory(5)->create();

        // For each parent, create subcategories
        $parents->each(function ($parent) {
            Category::factory(rand(2, 3))
                ->create([
                    'parent_id' => $parent->id,
                ]);
        });

        // Optionally create deeper levels (nested)
        $subcategories = Category::whereNotNull('parent_id')->get();
        $subcategories->each(function ($subcategory) {
            // 50% chance to give this subcategory some children
            if (rand(0, 1)) {
                Category::factory(rand(1, 2))
                    ->create([
                        'parent_id' => $subcategory->id,
                    ]);
            }
        });
    }
}
