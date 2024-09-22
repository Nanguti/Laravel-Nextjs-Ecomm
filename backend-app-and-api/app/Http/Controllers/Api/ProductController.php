<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product\Product as ProductProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = ProductProduct::with([
            'category',
            'brand',
        ])->get();
        return response()->json($products);
    }

    // Show a single product
    public function show($id)
    {
        $product = ProductProduct::with([
            'category',
            'brand',
            'reviews'
        ])->findOrFail($id);
        return response()->json($product);
    }

    // Create a new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'sku' => 'required|string|unique:products',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = ProductProduct::create($request->all());
        return response()->json($product, 201);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $id,
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'image' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = ProductProduct::findOrFail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    // Delete a product
    public function destroy($id)
    {
        $product = ProductProduct::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
