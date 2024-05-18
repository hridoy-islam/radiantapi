<?php

namespace Database\Factories;
use App\Models\Payments;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payments>
 */
class PaymentsFactory extends Factory
{
    protected $model = Payments::class;

    public function definition(): array
    {
        return [
            'order_id' => function () {
                return \App\Models\Order::factory()->create()->id;
            },
            'payment_method' => $this->faker->randomElement(['sslcommerz', 'Bkash', 'Nagad', 'upay', 'rocket']),
            'amount' => $this->faker->randomFloat(2, 10, 200),
            'transaction_id' => $this->faker->uuid,
        ];
    }
}
