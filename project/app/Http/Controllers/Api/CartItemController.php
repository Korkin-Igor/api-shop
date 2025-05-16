<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartItemService;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartItemService $cartItemService, Request $request, CartItem $cartItem)
    {
        if (auth()->user()->can('view', $cartItem)) {
            return $cartItemService->index($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartItemService $cartItemService, Request $request, CartItem $cartItem)
    {
        if (auth()->user()->can('create', $cartItem)) {
            return $cartItemService->store($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItemService $cartItemService, Request $request, CartItem $cartItem)
    {
        if (auth()->user()->can('delete', $cartItem)) {
            return $cartItemService->destroy($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }
}
