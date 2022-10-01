<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Product_Status extends Model
{
    use HasFactory;

    /**
     * Get the status that owns the Customer_Product.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
