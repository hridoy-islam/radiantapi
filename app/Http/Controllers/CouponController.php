<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Traits\HandlesApiRequests;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class CouponController extends BaseController
{

    use HandlesApiRequests;
    public function index(Request $request)
    {
        try {
            $query = Coupon::query();
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

    public function store(Request $request)
    {

       
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:coupons',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_amount' => 'required|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:0',
                'expires_at' => 'nullable|date',
        ]);
    
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }

        try {
            // Attempt to create a new color
            $query = Coupon::create($request->all());
            return $this->sendSuccessResponse('Record created successfully', $query, 201);
        } catch (ModelNotFoundException $e) {
            // Handle any unexpected errors
            return $this->sendErrorResponse('Failed to create record', 500);
        }


    }

    public function show($id)
    {
        try {
            $query = Coupon::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $query);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'sometimes|required|string|unique:coupons',
                'discount_type' => 'sometimes|required|in:percentage,fixed',
                'discount_amount' => 'sometimes|required|numeric|min:0',
                'usage_limit' => 'sometimes|nullable|integer|min:0',
                'expires_at' => 'sometimes|nullable|date',
            ]);
        
            if ($validator->fails()) {
                return $this->sendErrorResponse($validator->errors(), 404);
            }
    
            // Find the Coupon by ID
            $query = Coupon::findOrFail($id);
            $query->update($request->all());
            return $this->sendSuccessResponse('Record updated successfully', $query);
        }catch (ModelNotFoundException $e) {
            // Handle other exceptions (e.g., not found)
            return $this->sendErrorResponse('Record Not Found', 404);
        }

    }

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->where(function ($query) {
                $query->whereNull('usage_limit')->orWhere('usage_limit', '>', 0);
            })
            ->first();

        if (!$coupon) {
            
            return $this->sendErrorResponse('Invalid coupon code', 404);
        }

        return $this->sendSuccessResponse('Valid Coupon Code', $coupon);
    }
    public function destroy($id)
    {
        try {
            $query = Coupon::findOrFail($id);
            $query->delete();
            return $this->sendSuccessResponse('Record deleted successfully', $query);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404); 
        }
    }
}
