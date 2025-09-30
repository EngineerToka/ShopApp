<?php

namespace Database\Factories\Order;

use Carbon\Carbon;
use App\Models\Order\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
     protected $model = Coupon::class;
    public function definition()
    {
        return [
            'code' => strtoupper($this->faker->bothify('CODE###')),
            'type' => $this->faker->randomElement(['fixed','percent']),
            'value' => $this->faker->numberBetween(5,50),
            'min_order' => null,
            'max_uses' => null,
            'expires_at' => Carbon::now()->addDays(10),
            'active' => true,
        ];
    }
}
