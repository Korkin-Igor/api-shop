<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if (!AuthController::isAdmin($request)) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
        Product::query()->create($request->all());
        $id = Product::query()->get()->last()->id;
        return response()->json([
            'id' => $id,
            'message' => 'Product added'
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        if (!AuthController::isAdmin($request)) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
        if (preg_match('/^[0-9]+$/', $id) && Product::where('id', $id)->exists()) {
            $product = Product::query()->find($id);
            $product->update($request->all());
            return response()->json([$product]);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if (!AuthController::isAdmin($request)) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
        if (preg_match('/^[0-9]+$/', $id) && Product::where('id', $id)->exists()) {
            Product::where('id', $id)->delete();
            return response()->json([
                'message' => 'Product removed'
            ]);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }
}
