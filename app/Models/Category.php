<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug'; // then pass slug below
    }

/**
 * Get the FAQs for the category.
 */
public function faqs(): \Illuminate\Database\Eloquent\Relations\HasMany|Category
{
    return $this->hasMany(Faq::class);
}

}
