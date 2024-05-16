<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\HandlesApiRequests;
use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = User::query();
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
        $user = User::find($id);

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

        $validatedData = $request->validate([
            'name' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email',
            'password' => 'sometimes|string',

        ]);

          // Check which fields are present in the request and update them
        foreach ($validatedData as $key => $value) {
            $user->$key = $value;
        }
        $user->save();

        return $this->sendSuccessResponse('User updated successfully', $user);
    }
}
