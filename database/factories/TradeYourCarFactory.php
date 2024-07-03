<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TradeYourCar;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TradeYourCar>
 */
class TradeYourCarFactory extends Factory
{
    protected $model = TradeYourCar::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'current_car_brand' => $this->faker->randomElement(['Toyota', 'Honda', 'Ford', 'Chevrolet', 'Nissan']),
            'current_car_model' => $this->faker->randomElement(['Camry', 'Civic', 'F-150', 'Impala', 'Altima']),
            'current_car_year' => $this->faker->numberBetween(2000, 2022),
            'current_car_mileage' => $this->faker->numberBetween(0, 300000),
            'current_car_transmission_type' => $this->faker->randomElement(['Automatic', 'Manual']),
            'current_car_photos' => json_encode([$this->faker->imageUrl, $this->faker->imageUrl, $this->faker->imageUrl]),
            'current_car_special_notes' => $this->faker->optional()->realText(200),
            'expected_car_model' => $this->faker->randomElement(['Camry', 'Civic', 'F-150', 'Impala', 'Altima']),
            'expected_car_year' => $this->faker->numberBetween(2023, 2025),
            'expected_car_mileage' => $this->faker->numberBetween(0, 50000),
            'expected_car_transmission_type' => $this->faker->randomElement(['Automatic', 'Manual']),
            'expected_car_special_notes' => $this->faker->optional()->realText(200),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
