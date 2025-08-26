<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{

    public function index()
    {
        $products = Product::with('images')->latest()->paginate(20);

        return response()->json($products);
    }

    public function create()
    {
        //
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
             'message' => 'Product created successfully',
             'products' =>$product 
            ],201);
    }

    public function show($id)
    {
        $product= Product::with('images','user')->findOrFail($id)->append('MainImage');

        return response()->json($product);
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
             'message' => 'Product updated successfully',
             'product' =>$product->fresh(),
            ],201);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $product->delete();

         return response()->json(['message' => 'Product deleted successfully']);
    }
}
