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

    public function orders()
    {
        return $this->hasMany(Order::class, 'copoun_id', 'id');
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function($copoun){
            $copoun->code= 'Cup'.strtoupper(uniqid());
        });

    }

}
