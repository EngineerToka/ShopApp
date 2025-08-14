<?php

namespace App\Models\Cart;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;
    protected $table='cart_items';
    protected $fillable = ['quantity', 'product_id', 'cart_id'];

     public function cart()
    {
        return $this->belongsTo(Cart::class,'cart_id','id');
    }
     public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
