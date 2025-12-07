<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dishes';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'thumbnail',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'dish_ingredient')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function wishedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $query = $query->when(
            isset($filters['min_price']) || isset($filters['max_price']),
            function ($query) use ($filters) {
                if (isset($filters['min_price'])) {
                    $query->where('price', '>=', $filters['min_price']);
                }
                if (isset($filters['max_price'])) {
                    $query->where('price', '<=', $filters['max_price']);
                }
            }
        )->when(
        // Keep backward compatibility with old 'price' filter
            !isset($filters['min_price']) && !isset($filters['max_price']) && isset($filters['price']),
            fn ($query, $value) => $query->where('price', '<=', $filters['price'])
        )->when(
            $filters['search'] ?? false,
            fn ($query, $value) => $query->where('name', 'like', '%' . $value . '%')
        )->when(
            $filters['limit'] ?? false,
            fn ($query, $value) => $query->limit($value)
        )->when(
            $filters['ingredients'] ?? false,
            fn ($query) => $query->whereHas('ingredients', function ($query) use ($filters) {
                $query->whereIn('ingredients.id', $filters['ingredients']);
            })
        )->when(
            !empty($filters['categories']),
            function ($query) use ($filters) {
                // Collect all children recursively
                $allCategoryIds = [];
                $categories = Category::with('children')->findMany($filters['categories']);

                foreach ($categories as $category) {
                    $allCategoryIds = array_merge($allCategoryIds, $category->getAllChildrenIds());
                }

                $query->whereIn('category_id', $allCategoryIds);
            }
        );

        // Apply sorting
        if (!empty($filters['sort_by'])) {
            $direction = strtolower($filters['sort_direction'] ?? 'asc');
            // Validate direction
            $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

            match ($filters['sort_by']) {
                'price' => $query->orderBy('price', $direction),
                'name' => $query->orderBy('name', $direction),
                'created_at' => $query->orderBy('created_at', $direction),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        return $query;
    }

    public function scopeHasPattern (Builder $query, string $pattern): Builder
    {
        return $query->where('name', 'like', '%' . $pattern . '%');
    }
}
