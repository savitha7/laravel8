<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The product that belong to the category.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
