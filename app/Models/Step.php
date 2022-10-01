<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    /**
     * Get the product for the step.
     */
    public function product()
    {
        return $this->hasMany(Product_Step::class);
    }

    /**
     * Get all of the customer product for the step.
     */
    public function customer_product()
    {
        return $this->hasManyThrough(Customer_Product_Status::class, Product_Step::class);
    }
}
