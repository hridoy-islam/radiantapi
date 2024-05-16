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
            'order_number' => $this->faker->unique()->randomNumber(),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'total_amount' => $this->faker->randomFloat(2, 10, 500),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'order_items' => function () {
                $orderItems = [];
                $numberOfItems = $this->faker->numberBetween(1, 5);
                for ($i = 0; $i < $numberOfItems; $i++) {
                    $orderItems[] = [
                        'product_variation_id' => \App\Models\ProductVariation::factory()->create()->id,
                        'quantity' => $this->faker->numberBetween(1, 10),
                        'price' => $this->faker->randomFloat(2, 10, 200),
                    ];
                }
                return $orderItems;
            },
            'product_variations' => function () {
                $productVariations = [];
                $numberOfVariations = $this->faker->numberBetween(1, 3);
                for ($i = 0; $i < $numberOfVariations; $i++) {
                    $productVariations[] = [
                        'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
                        'color' => $this->faker->colorName(),
                        'price' => $this->faker->randomFloat(2, 10, 200),
                    ];
                }
                return $productVariations;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
