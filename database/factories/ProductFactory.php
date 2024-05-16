<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'url' => $this->faker->unique()->slug,
            'title' => $this->faker->sentence,
            'meta_description' => $this->faker->paragraph,
            'meta_keywords' => $this->faker->words(5, true),
            'og_title' => $this->faker->sentence,
            'og_description' => $this->faker->paragraph,
            'og_image' => $this->faker->imageUrl(),
            'category_id' => rand(1, 10),
            'image_gallery' => json_encode([$this->faker->imageUrl(), $this->faker->imageUrl()]),
            'sku' => $this->faker->unique()->ean13,
            'stock' => $this->faker->numberBetween(0, 100),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color' => $this->faker->colorName,
            'description' => $this->faker->paragraph,
            'short_description' => $this->faker->sentence,
            'review' => $this->faker->paragraph,
            'brand_id' => rand(1, 10),
        ];
    }
}
