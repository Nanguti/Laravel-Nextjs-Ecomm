<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // List all posts
    public function index()
    {
        $posts = BlogPost::all();
        return response()->json($posts);
    }

    // Show a single post
    public function show($id)
    {
        $post = BlogPost::findOrFail($id);
        return response()->json($post);
    }

    // Create a new post
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = BlogPost::create($request->all());
        return response()->json($post, 201);
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author' => 'sometimes|required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = BlogPost::findOrFail($id);
        $post->update($request->all());

        return response()->json($post);
    }

    // Delete a post
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
