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
        return $query->when(
            $filters['price'] ?? false,
            fn ($query, $value) => $query->where('price', '<=', $value)
        );
    }
}
