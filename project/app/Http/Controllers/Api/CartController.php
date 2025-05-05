<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{
    Cart,
    CartItem,
    Order,
};
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        if (AuthController::isAdmin($request)) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }

        $userId = $request->user()->id;
        $cartId = Cart::query()->where('user_id', $userId)->max('id');

        // если корзина пуста
        $cartItems = CartItem::all()->where('cart_id', $cartId);
        if ($cartItems->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 422);
        }

        foreach ($cartItems as $cartItem) {
            $product = [
                'user_id' => $userId,
                'order_id' => $cartId,
                'product_id' => $cartItem->product_id
            ];
            Order::query()->insert($product);
        }

        // делаем клиенту новую корзину, чтобы все новые товары добавлялись туда
        Cart::query()->where('user_id', $userId)->delete();
        CartItem::query()->where('cart_id', $cartId)->delete();
        Cart::query()->insert(['user_id' => $userId]);

        return response()->json([
            'order_id' => $cartId,
            'message' => 'Order is processed'
        ], 201);
    }
}
