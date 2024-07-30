<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finance_applicants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birthdate');
            $table->string('phone');
            $table->string('email');
            $table->string('sin');
            $table->string('marital_status');
            $table->text('civic_address');
            $table->string('postal_code');
            $table->string('box_number')->nullable();
            $table->string('residence_duration');
            $table->string('residence_type');
            $table->string('mortgage_lender')->nullable();
            $table->decimal('amount_owing_on_mortgage', 20, 2)->nullable();
            $table->decimal('current_value_of_property', 20, 2)->nullable();
            $table->decimal('payment_per_month_or_biweekly', 20, 2)->nullable();
            $table->string('payment_frequency')->nullable();
            $table->text('previous_address')->nullable();
            $table->string('previous_postal_code')->nullable();
            $table->string('previous_residence_duration')->nullable();
            $table->string('employer_company');
            $table->text('employer_address');
            $table->string('employer_phone');
            $table->string('employer_supervisor');
            $table->string('employment_type');
            $table->string('ei_off_season')->nullable();
            $table->string('position');
            $table->string('employment_duration');
            $table->string('previous_employer_company')->nullable();
            $table->text('previous_employer_address')->nullable();
            $table->string('previous_employer_phone')->nullable();
            $table->string('previous_employer_supervisor')->nullable();
            $table->string('previous_employment_type')->nullable();
            $table->string('previous_ei_off_season')->nullable();
            $table->string('previous_position')->nullable();
            $table->string('previous_employment_duration')->nullable();
            $table->decimal('gross_annual_income', 20, 2)->nullable();
            $table->decimal('gross_monthly_income', 20, 2)->nullable();
            $table->decimal('gross_biweekly_income', 20, 2)->nullable();
            $table->decimal('hourly_wage', 20, 2)->nullable();
            $table->integer('hours_per_week')->nullable();
            $table->decimal('other_monthly_income_rental', 20, 2)->nullable();
            $table->decimal('other_monthly_income_ccb', 20, 2)->nullable();
            $table->decimal('other_monthly_income_spousal_support', 20, 2)->nullable();
            $table->decimal('other_monthly_income_pensions', 20, 2)->nullable();
            $table->decimal('other_monthly_income_side_business', 20, 2)->nullable();
            $table->decimal('other_monthly_income_side_job', 20, 2)->nullable();
            $table->decimal('other_monthly_income_other', 20, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_applicants');
    }
};
