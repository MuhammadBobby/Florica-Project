<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'recipient_phone',
        'address',
        'latitude',
        'longitude',
        'district',
        'city',
        'province',
        'is_default',
        'postal_code',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];


    // ============= RELATIONSHIPS =============
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
