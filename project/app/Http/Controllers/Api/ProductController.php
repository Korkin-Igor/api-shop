<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductService $productService)
    {
        return $productService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductService $productService, StoreProductRequest $request, Product $product)
    {
        if (auth()->user()->can('create', $product)) {
            return $productService->store($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductService $productService, UpdateProductRequest $request, Product $product)
    {
        if (auth()->user()->can('update', $product)) {
            return $productService->update($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductService $productService, Request $request, Product $product)
    {
        if (auth()->user()->can('delete', $product)) {
            return $productService->destroy($request);
        } else {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
    }
}
