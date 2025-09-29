<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
            $slug = self::makeSimpleSlug($category->name);
            $count = Category::where('slug', $slug)->where('id', '!=', $category->id)->count();
            $category->slug = $count ? $slug . '-' . ($count + 1) : $slug;
        });
    }

    public static function makeSimpleSlug(string $name): string
    {
        return Str::slug($name);
    }
}
