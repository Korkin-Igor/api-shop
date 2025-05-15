<?php

namespace App\Http\Controllers\Api;

use App\Actions\CartStoreAction;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, Cart $cart)
    {
        if (auth()->user()->can('create', $cart)) {
            return CartStoreAction::execute($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }
}
