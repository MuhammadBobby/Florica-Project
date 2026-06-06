<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreProfile extends Model
{
    protected $fillable = [
        'store_name',
        'phone',
        'whatsapp',
        'email',
        'address',
        'latitude',
        'longitude',
        'district',
        'city',
        'province',
        'description',
    ];
}
