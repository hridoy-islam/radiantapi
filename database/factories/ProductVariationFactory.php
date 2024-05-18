<?php

namespace Database\Factories;

use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariationFactory extends Factory
{
    protected $model = ProductVariation::class;

    public function definition()
    {
        return [
            'product_id' => function () {
                return \App\Models\Product::factory()->create()->id;
            },
            'sku' => $this->faker->unique()->ean13,
            'stock' => $this->faker->numberBetween(0, 100),
            'size' => $this->faker->optional()->randomElement(['Small', 'Medium', 'Large']),
            'color' => $this->faker->optional()->safeColorName,
        ];
    }
}
