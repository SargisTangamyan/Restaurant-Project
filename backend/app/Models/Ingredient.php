<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ingredient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'unit',
        'price',
    ];

    protected static function booted(): void
    {
        static::saving(function ($ingredient) {
            $ingredient->slug = self::makeSimpleSlug($ingredient->name);
        });
    }

    public static function makeSimpleSlug(string $name): string
    {
        return Str::slug($name);
    }
}
