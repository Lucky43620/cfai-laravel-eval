<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProduitResource;
use Illuminate\Support\Str;
use App\Http\Requests\CreateProduitRequest;
use App\Services\ProductServices;

class ProductApiController extends ApiController
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $this->successResponse(new ProduitResource($product));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->successResponse(null, 'Product deleted successfully');
    }
} 