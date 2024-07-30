<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;
use App\Models\SellYourCar;

class SellYourCarController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = SellYourCar::query();
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'mileage' => 'required|integer',
            'transmissiontype' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'comment' => 'nullable|string',
        ]);
        try {
            $sellYourCar = new SellYourCar;
            $sellYourCar->fill($validatedData);
            if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('sell_your_car_images', 'public');
                }
                $sellYourCar->images = json_encode($imagePaths);
            }
            $sellYourCar->save();
            return $this->sendSuccessResponse('Records created successfully', $sellYourCar);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An erorr occurd', 404);
        }
    }
}
