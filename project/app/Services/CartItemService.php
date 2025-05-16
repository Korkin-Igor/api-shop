<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartItemService
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        // беру max(id), т.к. именно он обозначает текущую корзину
        $cartId = Cart::query()->where('user_id', $userId)->max('id');

        // через цикл перебираю товары
        $result = [];
        $cartItems = CartItem::all()->where('cart_id', $cartId);
        foreach ($cartItems as $cartItem) {
            $name = Product::query()->where('id', $cartItem->product_id)->value('name');
            $description = Product::query()->where('id', $cartItem->product_id)->value('description');
            $price = Product::query()->where('id', $cartItem->product_id)->value('price');
            $product = [
                'id' => $cartItem->id,
                'product_id' => $cartItem->product_id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
            ];
            array_push($result, $product);
        }
        return response()->json($result);
    }

    public function store(Request $request)
    {
        $productId = (int)$request->product_id;

        // проверка существует ли такой товар
        if (Product::where('id', $productId)->exists()) {
            $userId = $request->user()->id;
            $cartId = Cart::query()->where('user_id', $userId)->max('id');

            // присвоение id товару на уровне корзины
            // если товары были, то будет макс id+1
            // если не было, то будет id = 1
            if (CartItem::query()->where('cart_id', $cartId)->exists()) {
                $lastId = CartItem::query()->where('cart_id', $cartId)->max('id');
                $id = $lastId + 1;
            } else { $id = 1; }
            CartItem::query()->create([
                'id' => $id,
                'cart_id' => $cartId,
                'product_id' => $productId,
            ]);

            return response()->json([
                'message' => 'Product add to card'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    public function destroy(Request $request)
    {
        $cartItemId = $request->product_id;
        $userId = $request->user()->id;
        $cartId = Cart::query()->where('user_id', $userId)->max('id');
        if (CartItem::query()->where('cart_id', $cartId)->where('id', $cartItemId)->exists()) {
            CartItem::query()->where('cart_id', $cartId)->where('id', $cartItemId)->delete();
            return response()->json([
                'message' => 'Item removed from cart'
            ]);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }
}
