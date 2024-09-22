<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Review;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug' => 'required|string'
        ]);
        $product_info = Review::getProductBySlug($request->slug);
        $data = $request->all();
        $data['product_id'] = $product_info->id;
        $data['user_id'] = $request->user_id ? $request->user_id : 1;
        $data['status'] = 'active';
        $status = Review::create($data);

        if ($status) {
            return response()->json('success', 'Thank you for your feedback');
        } else {
            return response()->json('error', 'Something went wrong! Please try again!!');
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
        $review = Review::find($id);
        if ($review) {;
            $data = $request->all();
            $status = $review->fill($data)->update();
            if ($status) {
                return response()->json('success', 'Review Successfully updated');
            } else {
                return response()->json(
                    'error',
                    'Something went wrong! Please try again!!'
                );
            }
        } else {
            return response()->json('error', 'Review not found!!');
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
        $review = Review::find($id);
        $status = $review->delete();
        if ($status) {
            return response()->json('success', 'Successfully deleted review');
        } else {
            return response()->json('error', 'Something went wrong! Try again');
        }
    }
}
