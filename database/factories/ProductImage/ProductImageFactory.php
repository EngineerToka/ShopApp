<?php

namespace Database\Factories\ProductImage;

use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;
    
    public function definition()
    {
       return [
            'path'          => 'products/' . $this->faker->image('storage/app/public/products', 640, 480, null, false),
            'orignal_name'  => $this->faker->word . '.jpg',
            'attachable_id' => Product::factory(),
            'attachable_type' => Product::class,
        ];
    }
}
