<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order\PromotionalCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionalCodeController extends Controller
{
    // List all promotional codes
    public function index()
    {
        $codes = PromotionalCode::all();
        return response()->json($codes);
    }

    // Show a single promotional code
    public function show($id)
    {
        $code = PromotionalCode::findOrFail($id);
        return response()->json($code);
    }

    // Create a new promotional code
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:promotional_codes',
            'discount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $code = PromotionalCode::create($request->all());
        return response()->json($code, 201);
    }

    // Update a promotional code
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'sometimes|required|string|unique:promotional_codes,code,' . $id,
            'discount' => 'sometimes|required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $code = PromotionalCode::findOrFail($id);
        $code->update($request->all());

        return response()->json($code);
    }

    // Delete a promotional code
    public function destroy($id)
    {
        $code = PromotionalCode::findOrFail($id);
        $code->delete();
        return response()->json(['message' => 'Promotional code deleted successfully']);
    }
}
