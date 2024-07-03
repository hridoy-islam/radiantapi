<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FinanceApplicant;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinanceApplicant>
 */
class FinanceApplicantFactory extends Factory
{
    protected $model = FinanceApplicant::class; 

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'birthdate' => $this->faker->date(),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'sin' => $this->faker->numerify('###-###-###'),
            'marital_status' => $this->faker->randomElement(['single', 'married', 'divorced']),
            'civic_address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'box_number' => $this->faker->optional()->numerify('Box ###'),
            'residence_duration' => $this->faker->numberBetween(1, 30) . ' years',
            'residence_type' => $this->faker->randomElement(['owned', 'rented']),
            'mortgage_lender' => $this->faker->optional()->company,
            'amount_owing_on_mortgage' => $this->faker->optional()->randomFloat(2, 10000, 500000),
            'current_value_of_property' => $this->faker->optional()->randomFloat(2, 50000, 1000000),
            'payment_per_month_or_biweekly' => $this->faker->randomFloat(2, 500, 5000),
            'payment_frequency' => $this->faker->randomElement(['monthly', 'biweekly']),
            'previous_address' => $this->faker->optional()->address,
            'previous_postal_code' => $this->faker->optional()->postcode,
            'previous_residence_duration' => $this->faker->optional()->numberBetween(1, 30) . ' years',
            'employer_company' => $this->faker->company,
            'employer_address' => $this->faker->address,
            'employer_phone' => $this->faker->phoneNumber,
            'employer_supervisor' => $this->faker->name,
            'employment_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'ei_off_season' => $this->faker->optional()->boolean,
            'position' => $this->faker->jobTitle,
            'employment_duration' => $this->faker->numberBetween(1, 20) . ' years',
            'previous_employer_company' => $this->faker->optional()->company,
            'previous_employer_address' => $this->faker->optional()->address,
            'previous_employer_phone' => $this->faker->optional()->phoneNumber,
            'previous_employer_supervisor' => $this->faker->optional()->name,
            'previous_employment_type' => $this->faker->optional()->randomElement(['full-time', 'part-time', 'contract']),
            'previous_ei_off_season' => $this->faker->optional()->boolean,
            'previous_position' => $this->faker->optional()->jobTitle,
            'previous_employment_duration' => $this->faker->optional()->numberBetween(1, 20) . ' years',
            'gross_annual_income' => $this->faker->optional()->randomFloat(2, 30000, 150000),
            'gross_monthly_income' => $this->faker->optional()->randomFloat(2, 2000, 12500),
            'gross_biweekly_income' => $this->faker->optional()->randomFloat(2, 1000, 6250),
            'hourly_wage' => $this->faker->optional()->randomFloat(2, 15, 50),
            'hours_per_week' => $this->faker->optional()->numberBetween(20, 40),
            'other_monthly_income_rental' => $this->faker->optional()->randomFloat(2, 0, 2000),
            'other_monthly_income_ccb' => $this->faker->optional()->randomFloat(2, 0, 500),
            'other_monthly_income_spousal_support' => $this->faker->optional()->randomFloat(2, 0, 3000),
            'other_monthly_income_pensions' => $this->faker->optional()->randomFloat(2, 0, 2000),
            'other_monthly_income_side_business' => $this->faker->optional()->randomFloat(2, 0, 5000),
            'other_monthly_income_side_job' => $this->faker->optional()->randomFloat(2, 0, 3000),
            'other_monthly_income_other' => $this->faker->optional()->randomFloat(2, 0, 5000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
