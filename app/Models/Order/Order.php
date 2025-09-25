<?php

namespace App\Models\Order;

use App\Models\User\User;
use App\Models\Order\Coupon;
use App\Models\Order\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
     protected $table = 'orders';
    protected $fillable= ['status','user_id','subtotal','discount','total','coupon_id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function copoun()
    {
        return $this->belongsTo(Coupon::class,'copoun_id','id');
    }
}
