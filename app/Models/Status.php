<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * Get the Customer_Product for the status.
     */
    public function customer_product()
    {
        return $this->hasMany(Customer_Product_Status::class);
    }
}
