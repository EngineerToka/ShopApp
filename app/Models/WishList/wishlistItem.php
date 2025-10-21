<?php

namespace App\Models\WishList;

use App\Models\Product\Product;
use App\Models\WishList\WishList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class wishlistItem extends Model
{
    use HasFactory;
        protected $table='wishlist_items';
    protected $fillable = ['product_id', 'wishlist_id'];

     public function wishList()
    {
        return $this->belongsTo(WishList::class,'wishlist_id','id');
    }
     public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
