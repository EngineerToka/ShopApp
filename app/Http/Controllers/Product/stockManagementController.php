<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Requests\stockMangementRequest;

class stockManagementController extends Controller
{
    public function update(stockMangementRequest $request,$productId)
    {
        $product = Product::findOrFail($productId);
         $product->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully.',
            'data'    => new ProductResource($product->fresh()->load(['category','images','user']))
        ]);
       

    }
}
