<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogPost;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Settings\Banner;

class HomePageController extends Controller
{
    public function home()
    {
        $featured = Product::where('status', 'active')
            ->where('is_featured', 1)->orderBy('price', 'DESC')
            ->limit(4)->get();
        $posts = BlogPost::where('status', 'active')
            ->orderBy('id', 'DESC')->limit(4)->get();
        $banners = Banner::where('status', 'active')
            ->limit(4)
            ->orderBy('id', 'DESC')->get();
        $brands = Brand::where('status', 'active')
            ->orderBy('id', 'DESC')->get();
        $categories = Category::where('status', 'active')
            ->where('is_parent', 1)->orderBy('title', 'ASC')
            ->get();

        return response()->json([
            'banners' => $banners,
            'brands' => $brands,
            'featured_products' => $featured,
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
}
