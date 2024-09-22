<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\Payment;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Place a new order
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_price' => 'required|numeric',
            'status' => 'required|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'total_price' => $request->total_price,
            'status' => $request->status
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => Product::find($item['product_id'])->price
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'amount' => $request->total_price,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        return response()->json($order, 201);
    }

    // Get order details
    public function show($id)
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($id);
        return response()->json($order);
    }

    // Update order status
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order);
    }
}
