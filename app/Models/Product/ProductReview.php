<?php

namespace App\Models\Product;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;
     protected $table = 'product_reviews';
    protected $fillable = ['product_id','user_id','rating','comment'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
