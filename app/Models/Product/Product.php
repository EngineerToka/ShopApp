<?php

namespace App\Models\Product;

use Carbon\Carbon;
use App\Models\User\User;
use App\Models\Cart\CartItem;
use App\Models\Order\OrderItem;
use App\Models\Category\Category;
use App\Models\Product\ProductImage;
use App\Models\Product\ProductReview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model 
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['title', 'description', 'quantity', 'price', 'discount_price', 'status','user_id','category_id'];
    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];

    public function images(): MorphMany
    {
        return $this->morphMany(ProductImage::class,'attachable');
    }
        public function getMainImageAttribute()
     {
        $image = $this->images()->first();
        return $image ? $image->image_url : null;
     }

      // Accessor for created_at to return formatted date
   //  public function getCreatedAtAttribute($value)
   //  {
   //      return Carbon::parse($value)->format('d M Y');
   //  }

     public function user(){
        return $this->belongsTo(User::class,'user_id','id');
     }
     public function cartItems(){
        return $this->hasMany(CartItem::class,'product_id','id');
     }
      public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'product_id','id');
    }
     public function wishListedBy(){
        return $this->belongsToMany(User::class,'wish_lists','product_id', 'user_id')->withTimestamps();
     }
     public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
     }
     public function reviews(){
        return $this->hasMany(ProductReview::class,'product_id','id');
     }

     public function getRatingAveregaeAttribute()
     {
          $avg = $this->reviews()->avg('rating');
          return $avg ? round($avg,1) : null;

     }
}

