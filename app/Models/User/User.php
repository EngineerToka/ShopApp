<?php

namespace App\Models\User;

use App\Models\WishList;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','adress','role','status','profile_image'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function products()
    {
      return $this->hasMany(Product::class,'user_id','id');
    }

     public function cart(){
        return $this->hasOne(Cart::class,'user_id','id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'user_id','id');
    }
      public function wishList()
    {
        return $this->belongsToMany(Product::class,'wish_lists','user_id', 'product_id')->withTimestamps();
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);

    }

    public function isAdmin()
    {
      return $this->role ==='admin';
    }
    public function isSeller()
    {
      return $this->role ==='seller';
    }



}
