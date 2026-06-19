<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'user_address_id',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'order_status',
        'shipping_note',
        'paid_at',
    ];

    protected $casts = [
        'order_status' => OrderStatus::class,
        'paid_at' => 'datetime',
    ];

    // ========== RELATIONSHIPS =============
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }
}
