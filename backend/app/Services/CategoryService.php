<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class CategoryService
{
    private const CACHE_KEY = 'categories_tree';
    private const CACHE_TTL = 3600; // 1 hour

    public function getCategoryTree(bool $useCache = true): Collection
    {
        if (!$useCache) {
            return $this->fetchCategoryTree();
        }

        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return $this->fetchCategoryTree();
        });
    }

    private function fetchCategoryTree(): Collection
    {
        return Category::rootCategories()
            ->withFullTree()
            ->get();
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    public function createCategory(array $data): Category
    {
        $this->validateCircularReference($data);

        $category = Category::create($data);
        $this->clearCache();

        return $category->load('childrenRecursive');
    }

    public function updateCategory(Category $category, array $data): Category
    {
        $this->validateCircularReference($data, $category->id);

        $category->update($data);
        $this->clearCache();

        return $category->fresh('childrenRecursive');
    }

    public function deleteCategory(Category $category): bool
    {
        if ($category->hasChildren()) {
            throw new \Exception('Cannot delete category with subcategories.');
        }

        if ($category->dishes()->exists()) {
            throw new \Exception('Cannot delete category with associated dishes.');
        }

        $deleted = $category->delete();
        $this->clearCache();

        return $deleted;
    }

    private function validateCircularReference(array $data, ?int $categoryId = null): void
    {
        if (!isset($data['parent_id']) || !$data['parent_id']) {
            return;
        }

        $parentId = $data['parent_id'];

        // Check if trying to set itself as parent
        if ($categoryId && $parentId == $categoryId) {
            throw new \Exception('A category cannot be its own parent.');
        }

        // Check if the parent is a descendant (would create circular reference)
        if ($categoryId) {
            $parent = Category::find($parentId);
            if ($parent && $parent->isDescendantOf($categoryId)) {
                throw new \Exception('Cannot set a descendant category as parent (circular reference).');
            }
        }
    }

    public function searchCategories(string $query, int $perPage = 10)
    {
        return Category::where('name', 'LIKE', "%{$query}%")
            ->orWhere('slug', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->paginate($perPage);
    }
}
