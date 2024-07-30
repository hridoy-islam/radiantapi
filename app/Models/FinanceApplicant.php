<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
            'first_name',
            'middle_name',
            'last_name',
            'birthdate',
            'phone',
            'email',
            'sin',
            'marital_status',
            'civic_address',
            'postal_code',
            'box_number',
            'residence_duration',
            'residence_type',
            'mortgage_lender',
            'amount_owing_on_mortgage',
            'current_value_of_property',
            'payment_per_month_or_biweekly',
            'payment_frequency',
            'previous_address',
            'previous_postal_code',
            'previous_residence_duration',
            'employer_company',
            'employer_address',
            'employer_phone',
            'employer_supervisor',
            'employment_type',
            'ei_off_season',
            'position',
            'employment_duration',
            'previous_employer_company',
            'previous_employer_address',
            'previous_employer_phone',
            'previous_employer_supervisor',
            'previous_employment_type',
            'previous_ei_off_season',
            'previous_position',
            'previous_employment_duration',
            'gross_annual_income',
            'gross_monthly_income',
            'gross_biweekly_income',
            'hourly_wage',
            'hours_per_week',
            'other_monthly_income_rental',
            'other_monthly_income_ccb',
            'other_monthly_income_spousal_support',
            'other_monthly_income_pensions',
            'other_monthly_income_side_business',
            'other_monthly_income_side_job',
            'other_monthly_income_other',
    ];
}
