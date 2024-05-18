<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesApiRequests;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = Category::query();
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }

        $category = Category::create([
            'name' => $request->input('name'),
            // You can add other fields like slug, parent_id, etc. here
        ]);

        return $this->sendSuccessResponse('Record Created successfully', $category);
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $category);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendErrorResponse('Record Not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }

        $category->name = $request->input('name');
        // Update other fields as needed
        $category->save();

        return $this->sendSuccessResponse('Record created successfully', $category, 201);
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return $this->sendSuccessResponse('Record deleted successfully', $category);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404); 
        }
    }
}
