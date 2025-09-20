<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(Category::class);
}

}
