<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The categories that belong to the product.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /**
     * Get the prices for the product.
     */
    public function prices()
    {
        return $this->hasMany(Product_Price::class);
    }

    /**
     * The customers that belong to the product.
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    /**
     * The categories that belong to the product.
     */
    public function steps()
    {
        return $this->belongsToMany(Step::class)->withPivot('sequence');->withTimestamps();
    }
}
