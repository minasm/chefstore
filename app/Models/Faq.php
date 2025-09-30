<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
     use HasFactory;

    protected $fillable = [
        'category_id',
        'question',
        'answer',
    ];

/**
 * Get the category that owns the FAQ.
 */
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}

    protected function answer(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value
                ? preg_replace('/<a(.*?)>/', '<a$1 class="faq-link">', $value)
                : null,
        );
    }
}
