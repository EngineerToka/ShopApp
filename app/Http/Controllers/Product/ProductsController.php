<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{

    public function index()
    {
        $ProductResource = Product::with('images','category','user')->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved successfully.',
            'data' => ProductResource::collection($ProductResource),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
             'success' => true,
             'message' => 'Product created successfully',
             'products' => new ProductResource($product),
            ],201);
    }

    public function show($id)
    {
        $product= Product::with('images','user','category')->findOrFail($id)->append('MainImage');

        return ProductResource::collection($product );
    }

    public function edit($id)
    {
        //
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        return response()->json([
             'success' => true,
             'message' => 'Product updated successfully',
             'product' => new ProductResource($product) ,
            ],200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $product->delete();

         return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ],200);
    }
}
