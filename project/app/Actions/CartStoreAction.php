<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;

class CartStoreAction
{
    public static function execute(Request $request)
    {
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
