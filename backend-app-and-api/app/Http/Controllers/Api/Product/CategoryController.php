<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::getAllCategory();
        return response()->json($categories, 200);
    }


    public function getSubCategories(Request $request)
    {
        $category = Category::where('slug', $request->brand_slug)->first();
        $subCategories = Category::where('parent_id', $category->id)->get();
        return response()->json([
            'SubCategories' => $subCategories
        ]);
    }
}
