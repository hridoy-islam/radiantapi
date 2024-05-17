<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;
use Illuminate\Support\Facades\Validator;

class SizeController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        try {
            $query = Size::query();
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
            $size = Size::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $size);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sizes|max:255',
        ]);
    
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }

        try {
            // Attempt to create a new color
            $size = Size::create($request->all());
            return $this->sendSuccessResponse('Record created successfully', $size, 201);
        } catch (ModelNotFoundException $e) {
            // Handle any unexpected errors
            return $this->sendErrorResponse('Failed to create record', 500);
        }
    }

    public function update(Request $request,  $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:sizes|max:255',
            ]);
        
            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors(), 404);
            }
    
            // Find the brand by ID
            $size = Size::findOrFail($id);
            $size->update($request->all());
            return $this->sendSuccessResponse('Record updated successfully', $size);
        }catch (ModelNotFoundException $e) {
            // Handle other exceptions (e.g., not found)
            return $this->sendErrorResponse('Record Not Found', 404);
        }
    }

    public function destroy($id)
    {
        try {
            $size = Size::findOrFail($id);
            $size->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }
}
