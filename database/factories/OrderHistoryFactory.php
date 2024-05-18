<?php

namespace Database\Factories;
use App\Models\OrderHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderHistory>
 */
class OrderHistoryFactory extends Factory
{
    protected $model = OrderHistory::class;

    public function definition(): array
    {
        return [
            'order_id' => function () {
                return \App\Models\Order::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
        ];
    }
}
