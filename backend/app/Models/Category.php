<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    protected $casts = [
        'parent_id' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name);
            }
            $category->name = strtolower($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = static::generateUniqueSlug($category->name, $category->id);
            }
            $category->name = strtolower($category->name);
        });
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = static::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }

    // Relationships
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    // Scopes
    public function scopeRootCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithFullTree($query)
    {
        return $query->with('childrenRecursive');
    }

    // Helper methods
    public function getAllChildrenIds(): array
    {
        $ids = [$this->id];

        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }

        return $ids;
    }

    public function getAncestorIds(): array
    {
        $ids = [];
        $parent = $this->parent;

        while ($parent) {
            $ids[] = $parent->id;
            $parent = $parent->parent;
        }

        return $ids;
    }

    public function isDescendantOf(int $categoryId): bool
    {
        return in_array($categoryId, $this->getAncestorIds());
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }
}
