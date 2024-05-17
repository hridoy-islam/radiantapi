<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;

class ProductController extends BaseController
{
    use HandlesApiRequests;

    public function index(Request $request)
    {
        $query = Product::query()->with('category')->with('brand');
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
        $product = Product::findOrFail($id);
        return response()->json(['product' => $product]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|unique:products',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products',
            'stock' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product = Product::create($request->all());
        return response()->json(['product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'url' => 'required|unique:products,url,' . $id,
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|unique:products,sku,' . $id,
            'stock' => 'required|integer|min:0',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $product->update($request->all());
        return response()->json(['product' => $product]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
