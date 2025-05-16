<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersShowAction
{
    public static function execute(Request $request)
    {
        $userId = $request->user()->id;

        $result = [];

        $orders = Order::query()->where('user_id', $userId)->get()->groupBy('order_id');
        foreach ($orders as $order) {
            // сюда запишем товары и суммарные цены для заказа
            $products = [];
            $prices = 0;

            // перебираем заказ
            foreach ($order as $item) {

                $product = (int)$item['product_id'];
                array_push($products, $product);

                $price = Product::query()->find($product)->price;
                $prices += $price;
            }

            array_push($result, [
                'id' => $order[0]['order_id'],
                'products' => $products,
                'order_price' => $prices
            ]);
        }
        return $result;
    }
}
