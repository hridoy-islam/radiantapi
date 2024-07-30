<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesApiRequests;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactController extends BaseController
{
    
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = Contact::query();
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

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'content' => 'required|string',
        ]);

        try {
            $contact = new Contact;
            $contact->name = $validatedData['name'];
            $contact->email = $validatedData['email'];
            $contact->phone = $validatedData['phone'];
            $contact->content = $validatedData['content'];
            $contact->save();
    
            return $this->sendSuccessResponse('Record created successfully', $contact);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $query = Contact::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', $query);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404);
        }
    }


    public function destroy($id)
    {
        try {
            $query = Contact::findOrFail($id);
            $query->delete();
            return $this->sendSuccessResponse('Record deleted successfully', $query);
        } catch (ModelNotFoundException $e) {
            return $this->sendErrorResponse('No records found', 404); 
        }
    }
}
