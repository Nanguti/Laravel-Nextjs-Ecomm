<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    // List all discounts
    public function index()
    {
        $discounts = Discount::all();
        return response()->json($discounts);
    }

    // Show a single discount
    public function show($id)
    {
        $discount = Discount::findOrFail($id);
        return response()->json($discount);
    }

    // Create a new discount
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $discount = Discount::create($request->all());
        return response()->json($discount, 201);
    }

    // Update a discount
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'value' => 'sometimes|required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $discount = Discount::findOrFail($id);
        $discount->update($request->all());

        return response()->json($discount);
    }

    // Delete a discount
    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();
        return response()->json(['message' => 'Discount deleted successfully']);
    }
}
