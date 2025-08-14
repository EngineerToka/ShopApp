<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    protected $table ='product_images';
    protected $fillable = ['path'];

    public function attachable(): MorphTo
    {
      return $this->morphTo();
    }

    public function getImageUrlAttribute()
     {
        return $this->path ? asset('storage/' . $this->path) : asset('defaultImage/default.png');
     }


}
