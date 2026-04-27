<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DishReview extends Model
{
    protected $fillable = ['user_id', 'dish_id', 'rating', 'comment'];

    protected $casts = [
        'rating' => 'decimal:1',
    ];

    protected static function booted(): void
    {
        static::saved(fn (DishReview $review) => $review->dish->recalculateRating());
        static::deleted(fn (DishReview $review) => $review->dish->recalculateRating());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dish(): BelongsTo
    {
        return $this->belongsTo(Dish::class);
    }
}