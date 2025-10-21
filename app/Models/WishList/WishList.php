<?php

namespace App\Models\WishList;

use App\Models\User\User;
use App\Models\Product\Product;
use App\Models\WishList\wishlistItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WishList extends Model
{
    use HasFactory;
    protected $table='wish_lists';
    protected $fillable = ['user_id', 'product_id'];

    public function wishlistItems()
    {
        return $this->hasMany(wishlistItem::class,'wishlist_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

}
