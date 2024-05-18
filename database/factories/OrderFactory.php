<?php namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{

    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_number' => $this->faker->unique()->numberBetween(100000, 999999),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'total_amount' => $this->faker->randomFloat(2, 10, 200),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
        ];
    }
}
