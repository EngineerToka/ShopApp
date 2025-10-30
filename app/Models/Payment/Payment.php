<?php

namespace App\Models\Payment;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected $table = 'payments';

    use HasFactory;

   protected $fillable = [
        'order_id','payment_method','transaction_id','status','amount','response'
    ];

     protected $casts = [
        'response' => 'array',
        'amount' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id','id');
    }
}
