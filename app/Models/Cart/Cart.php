<?php

namespace App\Models\Cart;

use App\Models\User\User;
use App\Models\Cart\CartItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    protected $table='carts';
    protected $fillable = ['user_id'];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class,'cart_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
