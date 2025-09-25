<?php

namespace Database\Factories\Product;

use App\Models\Product\ProductReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductReviewFactory extends Factory
{
     protected $model = ProductReview::class;
     
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'user_id'    => User::factory(),
            'rating'     => $this->faker->numberBetween(1, 5),
            'comment'    => $this->faker->sentence(10),
        ];
    }
}
