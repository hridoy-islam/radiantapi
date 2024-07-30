<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;
use App\Models\FinanceApplicant;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class FinanceApplicantController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = FinanceApplicant::query();
        $results = $this->handleApiRequest($request, $query);

        // Convert $results to a collection if it's an array
        $results = collect($results);
        if ($results->isEmpty()) {
            return $this->sendErrorResponse('No records found', 404);
        }

        return $this->sendSuccessResponse('Records retrieved successfully', $results);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:finance_applicants',
            'sin' => 'required|string|max:255',
            'marital_status' => 'required|string|max:255',
            'civic_address' => 'required|string',
            'postal_code' => 'required|string|max:255',
            'box_number' => 'nullable|string|max:255',
            'residence_duration' => 'required|string|max:255',
            'residence_type' => 'required|string|max:255',
            'mortgage_lender' => 'nullable|string|max:255',
            'amount_owing_on_mortgage' => 'nullable|numeric',
            'current_value_of_property' => 'nullable|numeric',
            'payment_per_month_or_biweekly' => 'numeric',
            'payment_frequency' => 'string|max:255',
            'previous_address' => 'nullable|string',
            'previous_postal_code' => 'nullable|string|max:255',
            'previous_residence_duration' => 'nullable|string|max:255',
            'employer_company' => 'required|string|max:255',
            'employer_address' => 'required|string',
            'employer_phone' => 'required|string|max:255',
            'employer_supervisor' => 'required|string|max:255',
            'employment_type' => 'required|string|max:255',
            'ei_off_season' => 'string|max:255',
            'position' => 'required|string|max:255',
            'employment_duration' => 'required|string|max:255',
            'previous_employer_company' => 'nullable|string|max:255',
            'previous_employer_address' => 'nullable|string',
            'previous_employer_phone' => 'nullable|string|max:255',
            'previous_employer_supervisor' => 'nullable|string|max:255',
            'previous_employment_type' => 'nullable|string|max:255',
            'previous_ei_off_season' => 'string|max:255',
            'previous_position' => 'nullable|string|max:255',
            'previous_employment_duration' => 'nullable|string|max:255',
            'gross_annual_income' => 'nullable|numeric',
            'gross_monthly_income' => 'nullable|numeric',
            'gross_biweekly_income' => 'nullable|numeric',
            'hourly_wage' => 'nullable|numeric',
            'hours_per_week' => 'nullable|integer',
            'other_monthly_income_rental' => 'nullable|numeric',
            'other_monthly_income_ccb' => 'nullable|numeric',
            'other_monthly_income_spousal_support' => 'nullable|numeric',
            'other_monthly_income_pensions' => 'nullable|numeric',
            'other_monthly_income_side_business' => 'nullable|numeric',
            'other_monthly_income_side_job' => 'nullable|numeric',
            'other_monthly_income_other' => 'nullable|numeric',
        ]);
        try {
            $applicant = new FinanceApplicant($validatedData);
            $applicant->save();
    
            return $this->sendSuccessResponse('Record Created successfully', $applicant);

        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 404);
        }
    }

    public function show($id)
    {
        try {
            $query = FinanceApplicant::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $query);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }

    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
