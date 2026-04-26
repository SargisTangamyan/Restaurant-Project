<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Dish extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dishes';

    protected $fillable = [
        'slug',
        'category_id',
        'restaurant_id',
        'name',
        'description',
        'price',
        'image',
        'thumbnail',
        'average_rating',
        'reviews_count',
        'is_available',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'average_rating' => 'decimal:1',
        'reviews_count'  => 'integer',
        'is_available'   => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Dish $dish) {
            if (empty($dish->slug)) {
                $dish->slug = Str::slug($dish->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
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
            !isset($filters['min_price']) && !isset($filters['max_price']) && isset($filters['price']),
            fn ($query, $value) => $query->where('price', '<=', $filters['price'])
        )->when(
            $filters['search'] ?? false,
            fn ($query, $value) => $query->where('name', 'like', '%' . $value . '%')
        )->when(
            $filters['limit'] ?? false,
            fn ($query, $value) => $query->limit($value)
        )->when(
            $filters['restaurant_id'] ?? false,
            fn ($query, $value) => $query->where('restaurant_id', $value)
        )->when(
            isset($filters['is_available']),
            fn ($query) => $query->where('is_available', $filters['is_available'])
        )->when(
            $filters['ingredients'] ?? false,
            fn ($query) => $query->whereHas('ingredients', function ($query) use ($filters) {
                $query->whereIn('ingredients.id', $filters['ingredients']);
            })
        )->when(
            !empty($filters['categories']),
            function ($query) use ($filters) {
                $allCategoryIds = [];
                $categories = Category::with('children')->findMany($filters['categories']);

                foreach ($categories as $category) {
                    $allCategoryIds = array_merge($allCategoryIds, $category->getAllChildrenIds());
                }

                $query->whereIn('category_id', $allCategoryIds);
            }
        );

        if (!empty($filters['sort_by'])) {
            $direction = strtolower($filters['sort_direction'] ?? 'asc');
            $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

            match ($filters['sort_by']) {
                'price'      => $query->orderBy('price', $direction),
                'name'       => $query->orderBy('name', $direction),
                'rating'     => $query->orderBy('average_rating', $direction),
                'created_at' => $query->orderBy('created_at', $direction),
                default      => $query->latest(),
            };
        } else {
            $query->latest();
        }

        return $query;
    }

    public function scopeHasPattern(Builder $query, string $pattern): Builder
    {
        return $query->where('name', 'like', '%' . $pattern . '%');
    }
}