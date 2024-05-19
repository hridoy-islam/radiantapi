<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\UserDetail;
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    protected $model = UserDetail::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'address' => $this->faker->address,
            'division' => $this->faker->state,
            'district' => $this->faker->city,
            'upazila' => $this->faker->citySuffix,
            'union' => $this->faker->streetName,
            'profile_picture' => $this->faker->imageUrl(),
        ];
    }
}
