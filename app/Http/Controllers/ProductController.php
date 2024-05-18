<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;

class ProductController extends BaseController
{
    use HandlesApiRequests;

    public function index(Request $request)
    {
        $query = Product::query()->with('variations')->with('category')->with('brand');
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
        //$product = Product::findOrFail($id);
        $product = Product::with('variations', 'brand', 'category')->findOrFail($id);
        return $this->sendSuccessResponse('Records retrieved successfully', $product);
    }

    public function store(Request $request)
{
    // Validate the incoming request data for product
    $validatedProductData = $request->validate([
        'name' => 'required|string',
        'url' => 'required|string|unique:products',
        'title' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'og_title' => 'nullable|string',
        'og_description' => 'nullable|string',
        'og_image' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'image_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow multiple images
        'sku' => 'required|string|unique:product_variations',
        'stock' => 'required|integer|min:0',
        'size' => 'nullable|string',
        'color' => 'nullable|string',
        'description' => 'required|string',
        'short_description' => 'nullable|string',
        'review' => 'nullable|string',
        'brand_id' => 'required|exists:brands,id',
    ]);

    // Store the images in the image gallery
    $imagePaths = [];
    if ($request->hasFile('image_gallery')) {
        foreach ($request->file('image_gallery') as $image) {
            $path = $image->store('product_images'); // You may customize the storage path as per your requirement
            $imagePaths[] = $path;
        }
    }

    // Create the product
    $product = Product::create(array_merge($validatedProductData, ['image_gallery' => $imagePaths]));

    // Validate the incoming request data for variations
    $variations = $request->input('variations', []);
    foreach ($variations as $variation) {
        $validatedVariationData = validator($variation, [
            'sku' => 'required|string|unique:product_variations,sku,NULL,id,product_id,' . $product->id,
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ])->validate();

        // Create variation associated with the product
        $product->variations()->create($validatedVariationData);
    }

    return response()->json(['message' => 'Product and variations stored successfully']);
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
