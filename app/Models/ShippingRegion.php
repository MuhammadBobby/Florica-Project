<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingRegion extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_name',
        'shipping_cost',
        'estimated_delivery',
        'is_active',
    ];


    // ========== RELATIONSHIPS =============
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
