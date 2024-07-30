<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\HandlesApiRequests;
use App\Models\Car;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CarController extends BaseController
{
    
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = Car::query();
        $results = $this->handleApiRequest($request, $query);

        // Convert $results to a collection if it's an array
        $results = collect($results);
        if ($results->isEmpty()) {
            return $this->sendErrorResponse('No records found', 404);
        }

        return $this->sendSuccessResponse('Records retrieved successfully', $results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $booleanFields = [
            'bluetooth',
            'cruiseControl',
            'smartphoneIntegration',
            'backupCamera',
            'multizoneAC',
            'rearAC',
            'keylessEntry',
            'antiLockBrakes',
            'powerSeats',
            'thirdRowSeating',
            'heatedSeats',
            'remoteStart'
        ];
    
        foreach ($booleanFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = filter_var($data[$field], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            } else {
                $data[$field] = false; // Default value if not set
            }
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image_gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'exterior_colour' => 'required|string|max:255',
            'interior_colour' => 'required|string|max:255',
            'body_style' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'stock' => 'required|string|max:255',
            'vin' => 'required|string',
            'km' => 'required|integer',
            'engine' => 'required|string|max:255',
            'fuel_efficiency' => 'required|string|max:255',
            'drivetrain' => 'required|string|max:255',
            'price' => 'required|integer',
            'year' => 'required|integer',
            'cartype' => 'required|string',
            'overview' => 'required|string',
            'bluetooth' => 'nullable|string',
            'cruiseControl' => 'nullable|string',
            'smartphoneIntegration' => 'nullable|string',
            'backupCamera' => 'nullable|string',
            'multizoneAC' => 'nullable|string',
            'rearAC' => 'nullable|string',
            'keylessEntry' => 'nullable|string',
            'antiLockBrakes' => 'nullable|string',
            'powerSeats' => 'nullable|string',
            'thirdRowSeating' => 'nullable|string',
            'heatedSeats' => 'nullable|string',
            'remoteStart' => 'nullable|string',
            'keyLessStart' => 'nullable|string',
            'streeingwheelcontrol' => 'nullable|string',
            'exterior' => 'nullable|string',
            'interior' => 'nullable|string',
            'entertainment' => 'nullable|string',
            'mechanical' => 'nullable|string',
            'safety' => 'nullable|string',
            'techspecs' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
        $car = new Car($validatedData);
        $car->name = $request->name;
        $car->url = Str::slug($request->name, '-');
        $car->exterior_colour = $request->exterior_colour;
        $car->interior_colour = $request->interior_colour;
        $car->body_style = $request->body_style;
        $car->transmission = $request->transmission;
        $car->stock = $request->stock;
        $car->vin = $request->vin;
        $car->km = $request->km;
        $car->engine = $request->engine;
        $car->fuel_efficiency = $request->fuel_efficiency;
        $car->drivetrain = $request->drivetrain;
        $car->price = $request->price;
        $car->year = $request->year;
        $car->cartype = $request->cartype;
        $car->overview = $request->overview;
        $car->bluetooth = $request->bluetooth;
        $car->cruiseControl = $request->cruiseControl;
        $car->smartphoneIntegration = $request->smartphoneIntegration;
        $car->backupCamera = $request->backupCamera;
        $car->multizoneAC = $request->multizoneAC;
        $car->rearAC = $request->rearAC;
        $car->keylessEntry = $request->keylessEntry;
        $car->antiLockBrakes = $request->antiLockBrakes;
        $car->powerSeats = $request->powerSeats;
        $car->thirdRowSeating = $request->thirdRowSeating;
        $car->heatedSeats = $request->heatedSeats;
        $car->remoteStart = $request->remoteStart;
        $car->exterior = $request->exterior;
        $car->interior = $request->interior;
        $car->entertainment = $request->entertainment;
        $car->mechanical = $request->mechanical;
        $car->safety = $request->safety;
        $car->techspecs = $request->techspecs;
        $car->title = $request->name;
        $car->meta_description = Str::limit($request->overview, 160);
        $car->meta_keywords = $this->generateMetaKeywords($request);
        $car->og_title = $request->name;
        $car->og_description = Str::limit($request->overview, 160);
        $imageGallery = [];
        if ($request->hasFile('image_gallery')) {
            foreach ($request->file('image_gallery') as $image) {
                // Store each image
                $imageName = $image->store('image_gallery', 'public');
                $imageGallery[] = $imageName;
            }
        }
        $car->image_gallery = json_encode($imageGallery);

        $car->save();
        return $this->sendSuccessResponse('Record created successfully', $car);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    
    private function uploadImages($images)
    {
        $uploadedImages = [];
        foreach ($images as $image) {
            $uploadedImages[] = $image->store('image_gallery', 'public');
        }
        return json_encode($uploadedImages);
    }

    private function uploadImage($image)
    {
        return $image->store('og_images', 'public');
    }

    private function generateMetaKeywords(Request $request)
    {
        $keywords = collect([$request->name, $request->exterior_colour, $request->interior_colour, $request->body_style])
                    ->map(function($word) {
                        return Str::slug($word);
                    })->implode(', ');

        return $keywords;
    }


    public function show($slug)
    {
        try {
            $car = Car::where('url', $slug)->firstOrFail();
            return $this->sendSuccessResponse('Records retrieved successfully', $car);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $car = Car::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|unique:cars,url',
            'image_gallery.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'exterior_colour' => 'sometimes|string|max:255',
            'interior_colour' => 'sometimes|string|max:255',
            'body_style' => 'sometimes|string|max:255',
            'transmission' => 'sometimes|string|max:255',
            'stock' => 'sometimes|string|max:255',
            'vin' => 'sometimes|string|max:17|unique:cars,vin',
            'km' => 'sometimes|integer',
            'engine' => 'sometimes|string|max:255',
            'fuel_efficiency' => 'sometimes|string|max:255',
            'drivetrain' => 'sometimes|string|max:255',
            'price' => 'sometimes|integer',
            'year' => 'sometimes|integer',
            'cartype' => 'sometimes|string',
            'overview' => 'sometimes|string',
            'features' => 'sometimes|nullable|json',
            'exterior' => 'sometimes|nullable|json',
            'interior' => 'sometimes|nullable|json',
            'entertainment' => 'sometimes|nullable|json',
            'mechanical' => 'sometimes|nullable|json',
            'safety' => 'sometimes|nullable|json',
            'techspecs' => 'sometimes|nullable|json',
            'title' => 'sometimes|nullable|string|max:255',
            'meta_description' => 'sometimes|nullable|string|max:160',
            'meta_keywords' => 'sometimes|nullable|string',
            'og_title' => 'sometimes|nullable|string|max:255',
            'og_description' => 'sometimes|nullable|string|max:255',
            'og_image' => 'sometimes|string',
            'status' => 'sometimes|string|in:available,sold'
        ]);

        try {
            if ($request->has('name')) {
                $car->name = $request->name;
                $car->url = Str::slug($request->name, '-');
            }

            if ($request->hasFile('image_gallery')) {
                $imageGallery = $this->uploadImages($request->file('image_gallery'));
                $car->image_gallery = $imageGallery;
    
                // Update the og_image with the first image from the gallery
                $galleryArray = json_decode($imageGallery);
                $car->og_image = $galleryArray[0] ?? $car->og_image;
            }

            $car->exterior_colour = $request->has('exterior_colour') ? $request->exterior_colour : $car->exterior_colour;
            $car->interior_colour = $request->has('interior_colour') ? $request->interior_colour : $car->interior_colour;
            $car->body_style = $request->has('body_style') ? $request->body_style : $car->body_style;
            $car->transmission = $request->has('transmission') ? $request->transmission : $car->transmission;
            $car->stock = $request->has('stock') ? $request->stock : $car->stock;
            $car->vin = $request->has('vin') ? $request->vin : $car->vin;
            $car->km = $request->has('km') ? $request->km : $car->km;
            $car->engine = $request->has('engine') ? $request->engine : $car->engine;
            $car->fuel_efficiency = $request->has('fuel_efficiency') ? $request->fuel_efficiency : $car->fuel_efficiency;
            $car->drivetrain = $request->has('drivetrain') ? $request->drivetrain : $car->drivetrain;
            $car->price = $request->has('price') ? $request->price : $car->price;
            $car->overview = $request->has('overview') ? $request->overview : $car->overview;
            $car->features = $request->has('features') ? $request->features : $car->features;
            $car->exterior = $request->has('exterior') ? $request->exterior : $car->exterior;
            $car->interior = $request->has('interior') ? $request->interior : $car->interior;
            $car->entertainment = $request->has('entertainment') ? $request->entertainment : $car->entertainment;
            $car->mechanical = $request->has('mechanical') ? $request->mechanical : $car->mechanical;
            $car->safety = $request->has('safety') ? $request->safety : $car->safety;
            $car->techspecs = $request->has('techspecs') ? $request->techspecs : $car->techspecs;
            $car->title = $request->has('title') ? $request->title : $car->title;
            $car->status = $request->has('status') ? $request->status : $car->status;

            $car->meta_description = $request->has('overview') ? Str::limit($request->overview, 160) : $car->meta_description;
            $car->meta_keywords = $request->has('name') ? $this->generateMetaKeywords($request) : $car->meta_keywords;
           
            $car->save();
            return $this->sendSuccessResponse('Record updated successfully', $car);

        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
