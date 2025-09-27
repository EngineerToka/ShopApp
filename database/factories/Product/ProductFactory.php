<?php

namespace Database\Factories\Product;

use App\Models\User\User;
use App\Models\Product\Product;
use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
   protected $model = Product::class;
   
    public function definition()
    {

        return [
            'user_id'=> User::factory(),
            'title' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(0, 50),
            'price' => $this->faker->numberBetween(10, 1000),
            'discount_price' => 'nullable|numeric|min:0',
            'status'=>true,
            'category_id'=>Category::factory(),
        ];
    }
}
