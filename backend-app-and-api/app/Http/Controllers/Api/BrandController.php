<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    // List all brands
    public function index()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    // Show a single brand
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    // Create a new brand
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $brand = Brand::create($request->all());
        return response()->json($brand, 201);
    }

    // Update a brand
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $brand = Brand::findOrFail($id);
        $brand->update($request->all());
        return response()->json($brand);
    }

    // Delete a brand
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully']);
    }
}
