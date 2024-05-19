<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HandlesApiRequests;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class UserController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = User::query()->with('userDetails');
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }
        try {
            // Create a new user with the validated data
            $user = User::create($validator->validated());
    
            // Return success response
            return $this->sendSuccessResponse('User created successfully', $user);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode === 1062) { // MySQL error code for duplicate entry violation
                return $this->sendErrorResponse('Phone number or email already exists', 409); // Return 409 Conflict
            } else {
                // For other database errors, return a generic error response
                return $this->sendErrorResponse('An error occurred while creating the user', 500); // Return 500 Internal Server Error
            }
        }
    }

    public function show($id)
    {
        $user = User::with('userDetails')->find($id);

        if (!$user) {
            return $this->sendErrorResponse('User not found', 404);
        }

        return $this->sendSuccessResponse('User retrieved successfully', $user);
    }
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if (!$user) {
            return $this->sendErrorResponse('User not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email',
            'password' => 'sometimes|string',
        ]);
    
        if ($validator->fails()) {
            return $this->sendErrorResponse($validator->errors(), 404);
        }

        foreach ($validator->validated() as $key => $value) {
            $user->$key = $value;
        }
        $user->save();

        return $this->sendSuccessResponse('User updated successfully', $user);
    }

    public function storeUserDetails(Request $request, $userId)
    {
        // Validate the incoming request data including profile picture
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'division' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'upazila' => 'required|string|max:255',
            'union' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate profile picture
        ]);

        $user = User::findOrFail($userId);

        if (!$user) {
            return $this->sendErrorResponse('User not found', 404);
        }

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $profilePicturePath;
        }

        // Create or update user details
        if ($user->userDetails) {
            // Update existing user details
            $user->userDetails()->update($validatedData);
        } else {
            // Create new user details
            $user->userDetails()->create($validatedData);
        }
        $updatedUser = User::with('userDetails')->findOrFail($userId);

        return $this->sendSuccessResponse('User updated successfully', $updatedUser);
    }
    public function updateUserDetails(Request $request, $userId)
    {
        // Validate the incoming request data including profile picture
        $validatedData = $request->validate([
            'address' => 'sometimes|string|max:255',
            'division' => 'sometimes|string|max:255',
            'district' => 'sometimes|string|max:255',
            'upazila' => 'sometimes|string|max:255',
            'union' => 'sometimes|string|max:255',
            'profile_picture' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Retrieve the user by user ID
        $user = User::findOrFail($userId);

        if (!$user) {
            return $this->sendErrorResponse('User not found', 404);
        }

        // Check if profile picture is uploaded
        if ($request->hasFile('profile_picture')) {
            // Store the uploaded file
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');

            // Add profile picture path to validated data
            $validatedData['profile_picture'] = $profilePicturePath;
        }

        // Update user details
        if ($user->userDetails) {
            // Update existing user details
            $user->userDetails()->update($validatedData);
        } else {
            // Create new user details
            $user->userDetails()->create($validatedData);
        }

        $updatedUser = User::with('userDetails')->findOrFail($userId);

        return $this->sendSuccessResponse('User updated successfully', $updatedUser);
    }
}
