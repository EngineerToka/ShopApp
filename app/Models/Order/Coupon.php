<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
 protected $table = 'coupons';

    protected $fillable = [
        'code',
        'type', // fixed or percent
        'value',
        'active',
        'max_uses',
        'used_count',
        'min_order',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'active'     => 'boolean',
    ];
}
