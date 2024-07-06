<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;
use App\Models\TradeYourCar;

class TradeYourCarController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = TradeYourCar::query();
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
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:your_table_name',
            'current_car_brand' => 'required|string|max:255',
            'current_car_model' => 'required|string|max:255',
            'current_car_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'current_car_mileage' => 'required|integer',
            'current_car_transmission_type' => 'required|string|max:255',
            'current_car_photos' => 'nullable|array|max:10',
            'current_car_photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_car_special_notes' => 'nullable|string',
            'expected_car_model' => 'required|string|max:255',
            'expected_car_year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'expected_car_mileage' => 'required|integer',
            'expected_car_transmission_type' => 'required|string|max:255',
            'expected_car_special_notes' => 'nullable|string',
        ]);

        try {
            $carExchangeRequest = new TradeYourCar($validatedData);

            // Handle current car photos upload and store as JSON
            if ($request->hasFile('current_car_photos')) {
                $photoPaths = [];
                foreach ($request->file('current_car_photos') as $photo) {
                    $photoPaths[] = $photo->store('current_car_photos', 'public');
                }
                $carExchangeRequest->current_car_photos = json_encode($photoPaths);
            }

            $carExchangeRequest->save();

            return $this->sendSuccessResponse('Records created successfully', $carExchangeRequest);
        } catch (\Exception $e) {
            
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    
}
