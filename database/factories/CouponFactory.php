<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition()
    {
        return [
            'code' => $this->faker->unique()->randomNumber(6),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed']),
            'discount_amount' => $this->faker->randomFloat(2, 0, 100),
            'usage_limit' => $this->faker->numberBetween(1, 100),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
