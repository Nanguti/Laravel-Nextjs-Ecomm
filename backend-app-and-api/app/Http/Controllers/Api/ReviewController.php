<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    // List all reviews
    public function index()
    {
        $reviews = Review::with('product')->get();
        return response()->json($reviews);
    }

    // Show a single review
    public function show($id)
    {
        $review = Review::with('product')->findOrFail($id);
        return response()->json($review);
    }

    // Create a new review
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return response()->json($review, 201);
    }

    // Update a review
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $review = Review::findOrFail($id);
        $review->update($request->all());

        return response()->json($review);
    }

    // Delete a review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json(['message' => 'Review deleted successfully']);
    }
}
