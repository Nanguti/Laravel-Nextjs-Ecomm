<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    // List all FAQs
    public function index()
    {
        $faqs = FAQ::all();
        return response()->json($faqs);
    }

    // Show a single FAQ
    public function show($id)
    {
        $faq = FAQ::findOrFail($id);
        return response()->json($faq);
    }

    // Create a new FAQ
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $faq = FAQ::create($request->all());
        return response()->json($faq, 201);
    }

    // Update an FAQ
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $faq = FAQ::findOrFail($id);
        $faq->update($request->all());

        return response()->json($faq);
    }

    // Delete an FAQ
    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();
        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
