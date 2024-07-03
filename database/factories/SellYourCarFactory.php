<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SellYourCar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellYourCar>
 */
class SellYourCarFactory extends Factory
{
    protected $model = SellYourCar::class;

    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'brand' => $this->faker->word,
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'mileage' => $this->faker->numberBetween(0, 200000),
            'transmissiontype' => $this->faker->randomElement(['Automatic', 'Manual']),
            'images' => json_encode($this->faker->words(3)), // Example with 3 random words. Adjust as needed.
            'comment' => $this->faker->text,
        ];
    }
}
