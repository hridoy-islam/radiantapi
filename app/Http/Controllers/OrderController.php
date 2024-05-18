<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HandlesApiRequests;
use App\Http\Controllers\BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderController extends Controller
{
    use HandlesApiRequests;
    public function index(Request $request)
    {
        $query = Order::query()->with('items')->with('history');
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
        $order = Order::create($request->all());
        return response()->json($order, 201);
        

    // OrderHistory::create([
    //     'order_id' => $order->id,
    //     'status' => $request->input('status'),
    // ]);

        // Process payment
    // $payment = Payment::create([
    //     'order_id' => $order->id,
    //     'payment_method' => $request->input('payment_method'),
    //     'amount' => $order->total_price,
    //     'transaction_id' => $transactionId // Retrieve transaction ID from Stripe or other payment gateway
    // ]);
        
    }

    public function show($id)
    {
        $product = Order::with('items', 'history')->findOrFail($id);
        return $this->sendSuccessResponse('Records retrieved successfully', $product);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return response()->json($order, 200);
    }

    public function destroy($id)
    {
        $query = Order::findOrFail($id);
        $query->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
