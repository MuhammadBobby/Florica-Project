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

    public function getStatusColorAttribute()
    {
        return match ($this->order_status) {
            OrderStatus::Pending => 'bg-yellow-100 text-yellow-700',
            OrderStatus::Success => 'bg-blue-100 text-blue-700',
            OrderStatus::Confirmed => 'bg-green-100 text-green-700',
            OrderStatus::Packed => 'bg-purple-100 text-purple-700',
            OrderStatus::Shipped => 'bg-green-100 text-green-700',
            OrderStatus::Completed => 'bg-green-100 text-green-700',
            OrderStatus::Cancelled => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
