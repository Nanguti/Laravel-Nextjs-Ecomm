<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionalCodeController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ProductController Routes
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

// CartController Routes
Route::middleware('auth:api')->group(function () {
    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/items', [CartController::class, 'store']);
    Route::put('cart/items/{id}', [CartController::class, 'update']);
    Route::delete('cart/items/{id}', [CartController::class, 'destroy']);
});

// OrderController Routes
Route::middleware('auth:api')->group(function () {
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::put('orders/{id}', [OrderController::class, 'update']);
});

// PostController Routes
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{id}', [PostController::class, 'show']);

// FAQController Routes
Route::get('faqs', [FaqController::class, 'index']);
Route::get('faqs/{id}', [FaqController::class, 'show']);


// PromotionalCodeController Routes
Route::get('promotional-codes', [PromotionalCodeController::class, 'index']);
Route::get('promotional-codes/{id}', [PromotionalCodeController::class, 'show']);

// DiscountController Routes
Route::get('discounts', [DiscountController::class, 'index']);
Route::get('discounts/{id}', [DiscountController::class, 'show']);

// ReviewController Routes
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{id}', [ReviewController::class, 'show']);
