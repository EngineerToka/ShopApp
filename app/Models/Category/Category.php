<?php

namespace App\Models\Category;

use App\Models\Product\Product;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
protected $fillable = ['name', 'slug', 'parent_id']; 

     public function products(){
        return $this->hasMany(Product::class,'category_id','id');
     }

     public function mainCategory(){
        return $this->belongsTo(Category::Class,'parent_id');
     }
     public function subCategories(){
        return $this->hasMany(Category::Class,'parent_id');
     }
}
