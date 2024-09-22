<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    // Get cart details
    public function show(Request $request)
    {
        $cart = Cart::where('session_id', $request->session_id)->orWhere(
            'user_id',
            $request->user()->id
        )->first();
        $cartItems = $cart ? $cart->items : [];
        return response()->json($cartItems);
    }

    // Add item to cart
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cart = Cart::firstOrCreate([
            'session_id' => $request->session_id,
            'user_id' => $request->user()->id
        ]);
        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cartItem, 201);
    }

    // Update item quantity
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cartItem = CartItem::findOrFail($id);
        $cartItem->update($request->all());

        return response()->json($cartItem);
    }

    // Remove item from cart
    public function destroy($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();
        return response()->json(['message' => 'Cart item removed successfully']);
    }
}
