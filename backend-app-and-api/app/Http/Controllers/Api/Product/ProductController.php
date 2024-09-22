<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Category;
use App\Models\Product\Brand;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::where('status', 'active')
            ->orderBy('order_column', 'ASC')
            ->paginate(9);

        return response()->json(['products' => $products]);
    }

    public function productsList()
    {
        $products = Product::where('status', 'active')
            ->orderBy('id', 'desc')->get();
        return response()->json([
            'products' => $products,
            'count' => $products->count()
        ]);
    }

    public function productDetail(Request $request)
    {
        $request->validate([
            'slug' => 'required'
        ]);
        $product_detail = Product::getProductBySlug($request->slug);
        $brands = Brand::where('status', 'active')
            ->orderBy('id', 'DESC')->get();
        $images = $product_detail->images;
        if ($product_detail) {
            return response()->json([
                'product_detail' => $product_detail,
                'brands' => $brands
            ]);
        }
        return response()->json([
            'product_detail' => null,
            'message' => 'Sorry, the product you are looking for could not be found'
        ]);
    }


    public function productSearch(Request $request)
    {
        $query = $request->query('query');
        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')->limit(4)->get();
        $products = Product::orwhere('title', 'like', '%' . $query . '%')
            ->orwhere('slug', 'like', '%' . $query . '%')
            ->orwhere('description', 'like', '%' . $query . '%')
            ->orwhere('summary', 'like', '%' . $query . '%')
            ->orwhere('price', 'like', '%' . $query . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        return response()->json([
            'products' => $products,
            'recent_products' => $recent_products
        ]);
    }


    public function productBrand(Request $request)
    {
        $results = Brand::getProductByBrand($request->slug);

        $paginatedProducts = $results->products()
            ->orderBy('order_column', 'ASC')
            ->paginate(9);

        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        return response()->json([
            'results' => $paginatedProducts,
            'recent_products' => $recent_products
        ]);
    }

    public function productCat(Request $request)
    {
        $category = Category::where('slug', $request->slug)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        $childCategories = Category::where('parent_id', $category->id)->get();

        $categoryIds = $childCategories->pluck('id')->prepend($category->id);

        $paginatedProducts = Product::whereHas(
            'categories',
            function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            }
        )->orderBy('order_column', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $allProducts = Product::whereHas(
            'categories',
            function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            }
        )->orderBy('order_column', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();

        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'allProducts' => $allProducts,
            'results' => $paginatedProducts,
            'subCategories' => $childCategories,
            'recent_products' => $recent_products,
        ]);
    }


    public function productSubCat(Request $request)
    {
        $results = Category::getProductBySubCat($request->sub_slug);

        $paginatedProducts = $results->products()
            ->orderBy('is_top', 'DESC')
            ->orderBy('id', 'DESC')
            ->paginate(9);

        $recent_products = Product::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(3)
            ->get();

        return response()->json([
            'results' => $paginatedProducts,
            'recent_products' => $recent_products
        ]);
    }
}
