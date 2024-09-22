<?php

namespace App\Http\Controllers\API\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogComment;
use App\Models\Blog\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post_info = BlogPost::getPostBySlug($request->slug);
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'active';
        $status = BlogComment::create($data);
        if ($status) {
            return response()->json([
                'message' => 'Comment successfully added',
                'status' => 201
            ]);
        } else {
            return response()->json([
                'error' => 'Sorry, an error occured, please try again'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = BlogComment::find($id);
        if ($comment) {
            $data = $request->all();
            // return $data;
            $status = $comment->fill($data)->update();
            if ($status) {
                return response()->json(['success' => 'Comment successfully updated']);
            } else {
                return response()->json(['error' => 'Something went wrong! Please try again!!']);
            }
        } else {
            return response()->json(['error' => 'Comment not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = BlogComment::find($id);
        if ($comment) {
            $status = $comment->delete();
            if ($status) {
                return response()->json(['success' => 'Post Comment successfully deleted']);
            } else {
                return response()->json(['error' => 'Error occurred please try again']);
            }
        } else {
            return response()->json(['error' => 'Post Comment not found']);
        }
    }
}
