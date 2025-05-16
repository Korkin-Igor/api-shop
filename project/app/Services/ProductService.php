<?php

namespace App\Services;

use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function index()
    {
        return Product::all();
    }

    public function store(StoreProductRequest $request)
    {
        Product::query()->create($request->all());
        $id = Product::query()->get()->last()->id;
        return response()->json([
            'id' => $id,
            'message' => 'Product added'
        ], 201);
    }

    public function update(UpdateProductRequest $request)
    {
        if (preg_match('/^[0-9]+$/', $request->id) && Product::where('id', $request->id)->exists()) {
            $product = Product::query()->find($request->id);
            $product->update($request->all());
            return response()->json([$product]);
        }
        return response()->json([
            'message' => 'Not found'
        ], 404);
    }

    public function destroy(Request $request)
    {
        if (preg_match('/^[0-9]+$/', $request->id) && Product::where('id', $request->id)->exists()) {
            Product::where('id', $request->id)->delete();
            return response()->json([
                'message' => 'Product removed'
            ]);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }
}
