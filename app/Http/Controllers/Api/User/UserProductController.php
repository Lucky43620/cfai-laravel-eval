<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class UserProductController extends ApiController
{
    public function index(Request $request)
    {
        $products = $request->user()
            ->orders()
            ->with('items.product.category')
            ->get()
            ->pluck('items.*.product')
            ->flatten()
            ->unique('id');

        return $this->successResponse(ProductResource::collection($products));
    }

    public function show(Request $request, $productId)
    {
        $product = $request->user()
            ->orders()
            ->with('items.product.category')
            ->whereHas('items', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->firstOrFail()
            ->items
            ->where('product_id', $productId)
            ->first()
            ->product;

        return $this->successResponse(new ProductResource($product));
    }
} 