<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected static function booted(): void
    {
        static::saving(function ($category) {
            $category->slug = self::makeSimpleSlug($category->name);
        });
    }

    public static function makeSimpleSlug(string $name): string
    {
        return Str::slug($name);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'category_id');
    }
}
