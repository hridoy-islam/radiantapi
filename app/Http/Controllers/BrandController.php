<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\HandlesApiRequests;
class BrandController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = Brand::query();
        $results = $this->handleApiRequest($request, $query);

        // Convert $results to a collection if it's an array
        $results = collect($results);
        if ($results->isEmpty()) {
            return $this->sendErrorResponse('No records found', 404);
        }

        return $this->sendSuccessResponse('Records retrieved successfully', $results);
    }

    public function show($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $brand);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }

    public function store(Request $request)
{
    $rules =[
        'name' => 'required|unique:brands',
        'description' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for the image
    ]);

    $brandData = $request->only(['name', 'description']);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('brands'); // Store the uploaded image
        $brandData['image'] = $imagePath;
    }

    $brand = Brand::create($brandData);
    return response()->json(['brand' => $brand], 201);
}

public function update(Request $request, $id)
{
    try {
        $color = Brand::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:brands,name,' . $id,
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brandData = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brands'); // Store the uploaded image
            $brandData['image'] = $imagePath;
        }

        $brand->update($brandData);
        return $this->sendSuccessResponse('Record updated successfully', $color);
    } catch (ModelNotFoundException $e) {
        return $this->sendErrorResponse('No records found', 404);
    }

}

    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }
}
