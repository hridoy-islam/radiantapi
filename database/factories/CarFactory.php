<?php

namespace Database\Factories;
use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'url' => $this->faker->slug,
            'image_gallery' => json_encode($this->faker->words(5)),
            'exterior_colour' => $this->faker->safeColorName,
            'interior_colour' => $this->faker->safeColorName,
            'body_style' => $this->faker->randomElement(['sedan', 'coupe', 'hatchback']),
            'transmission' => $this->faker->randomElement(['automatic', 'manual']),
            'stock' => Str::random(10),
            'vin' => $this->faker->unique()->bothify('???####???####'),
            'km' => $this->faker->numberBetween(0, 200000),
            'engine' => $this->faker->randomElement(['V6', 'V8', 'I4', 'I6']),
            'fuel_efficiency' => $this->faker->numberBetween(10, 20) . ' L/100km',
            'drivetrain' => $this->faker->randomElement(['FWD', 'RWD', 'AWD']),
            'price' => $this->faker->numberBetween(20000, 100000),
            'overview' => $this->faker->paragraph,
            'features' => json_encode($this->faker->words(10)),
            'exterior' => json_encode($this->faker->words(5)),
            'interior' => json_encode($this->faker->words(5)),
            'entertainment' => json_encode($this->faker->words(5)),
            'mechanical' => json_encode($this->faker->words(5)),
            'safety' => json_encode($this->faker->words(5)),
            'techspecs' => json_encode($this->faker->words(5)),
            'title' => $this->faker->sentence,
            'meta_description' => $this->faker->sentence,
            'meta_keywords' => json_encode($this->faker->words(5)),
            'og_title' => $this->faker->sentence,
            'og_description' => $this->faker->sentence,
            'og_image' => $this->faker->imageUrl,
            'status' => $this->faker->randomElement(['available', 'sold']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
