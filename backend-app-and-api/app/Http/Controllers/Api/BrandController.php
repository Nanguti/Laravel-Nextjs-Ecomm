<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product\Brand;

class BrandController extends Controller
{
    // List all brands
    public function index()
    {
        $brands = Brand::where('status', 'active')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($brands, 200);
    }
}
