<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The Products that belong to the customer.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
