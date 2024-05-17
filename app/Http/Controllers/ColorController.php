<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\HandlesApiRequests;
use Illuminate\Support\Facades\Validator;

class ColorController extends BaseController
{   use HandlesApiRequests;
    public function index(Request $request)
    {
        try {
            $query = Color::query();
            $results = $this->handleApiRequest($request, $query);
    
            // Convert $results to a collection if it's an array
            $results = collect($results);
            if ($results->isEmpty()) {
                return $this->sendErrorResponse('No records found', 404);
            }
            return $this->sendSuccessResponse('Records retrieved successfully', $results);
        }
        catch(\Exception $e){
            
            return $this->sendErrorResponse('Invalid query parameters', 400);
        }
    }

    public function show($id)
    {
        try {
            $color = Color::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $color);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:colors',
            ]);
        
            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors(), 404);
            }
    
            // Find the brand by ID
            $color = Color::findOrFail($id);
            $color->update($request->all());
            return $this->sendSuccessResponse('Record updated successfully', $color);
        }catch (ModelNotFoundException $e) {
            // Handle other exceptions (e.g., not found)
            return $this->sendErrorResponse('Record Not Found', 404);
        }

    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:colors',
        ]);
    
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }

        try {
            // Attempt to create a new color
            $color = Color::create($request->all());
            return $this->sendSuccessResponse('Record created successfully', $color, 201);
        } catch (ModelNotFoundException $e) {
            // Handle any unexpected errors
            return $this->sendErrorResponse('Failed to create record', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }
}
