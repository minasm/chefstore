<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
     use HasFactory;

/**
 * Get the FAQs for the category.
 */
public function faqs()
{
    return $this->hasMany(Faq::class);
}

}
