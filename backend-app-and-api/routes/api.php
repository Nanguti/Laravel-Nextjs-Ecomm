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
Route::middleware('auth:api')->group(function () {
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});

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
Route::middleware('auth:api')->group(function () {
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{id}', [PostController::class, 'update']);
    Route::delete('posts/{id}', [PostController::class, 'destroy']);
});

// FAQController Routes
Route::get('faqs', [FaqController::class, 'index']);
Route::get('faqs/{id}', [FaqController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('faqs', [FaqController::class, 'store']);
    Route::put('faqs/{id}', [FaqController::class, 'update']);
    Route::delete('faqs/{id}', [FaqController::class, 'destroy']);
});

// PromotionalCodeController Routes
Route::get('promotional-codes', [PromotionalCodeController::class, 'index']);
Route::get('promotional-codes/{id}', [PromotionalCodeController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('promotional-codes', [PromotionalCodeController::class, 'store']);
    Route::put('promotional-codes/{id}', [PromotionalCodeController::class, 'update']);
    Route::delete('promotional-codes/{id}', [PromotionalCodeController::class, 'destroy']);
});

// DiscountController Routes
Route::get('discounts', [DiscountController::class, 'index']);
Route::get('discounts/{id}', [DiscountController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('discounts', [DiscountController::class, 'store']);
    Route::put('discounts/{id}', [DiscountController::class, 'update']);
    Route::delete('discounts/{id}', [DiscountController::class, 'destroy']);
});

// ReviewController Routes
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{id}', [ReviewController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('reviews', [ReviewController::class, 'store']);
    Route::put('reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
});
