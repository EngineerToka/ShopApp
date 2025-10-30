<?php

namespace App\Models\Order;

use App\Models\User\User;
use App\Models\Order\Coupon;
use App\Models\Order\OrderItem;
use App\Models\Payment\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable= ['order_no','status','user_id','subtotal','discount','total','coupon_id','payment_status','payment_method','payment_reference','completed_at'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($order){
            $order->order_no= 'ORD'.strtoupper(uniqid());
        });

    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class,'coupon_id','id');
    }
    public function payment()
    {
        return $this->hasMany(Payment::class,'order_id','id');
    }
}
