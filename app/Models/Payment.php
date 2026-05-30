<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'payment_method',
        'midtrans_order_id',
        'transaction_id',
        'gross_amount',
        'payment_status',
        'snap_token',
        'raw_response',
        'paid_at',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'payment_status' => PaymentStatus::class,
        'paid_at' => 'datetime',
    ];


    // ========== RELATIONSHIPS =============
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
