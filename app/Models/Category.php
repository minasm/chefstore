<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'sort',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug'; // then pass slug below
    }

    /**
     * Bootstrap the model and its traits.
     */
    protected static function booted(): void
    {
        static::creating(function (Category $category): void {
            if ($category->sort !== null) {
                return;
            }

            $nextSort = (int) static::max('sort');

            $category->sort = $nextSort + 1;
        });
    }

    /**
     * Get the FAQs for the category.
     */
    public function faqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Faq::class);
    }

    /**
     * Generate a public URL for the stored image, if present.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        // Prefer the public disk so assets resolve without signed URLs.
        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        // Fall back to the default disk (e.g. legacy private uploads).
        if (Storage::exists($this->image)) {
            return Storage::url($this->image);
        }

        return null;
    }
}
