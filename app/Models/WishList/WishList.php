<?php

namespace App\Models;

use App\Models\User\User;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WishList extends Model
{
    use HasFactory;
    protected $table='wish_lists';
    protected $fillable = ['user_id', 'product_id'];

  
}
