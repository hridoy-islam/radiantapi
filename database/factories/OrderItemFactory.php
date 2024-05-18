<?php

namespace Database\Factories;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'order_id' => function () {
                return \App\Models\Order::factory()->create()->id;
            },
            'product_id' => function () {
                return \App\Models\Product::factory()->create()->id;
            },
            'quantity' => $this->faker->numberBetween(1, 10),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color' => $this->faker->colorName,
            'price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
