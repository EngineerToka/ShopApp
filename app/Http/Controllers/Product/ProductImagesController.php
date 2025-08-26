<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductImageRequest;


class ProductImagesController extends Controller
{

    public function index($productId)
    {
        $product =Product::with('images')->findOrFail($productId);

        return response()->json(
           $product->images
        );
    }

    public function store(ProductImageRequest $request,$productId)
    {
        $product = Product::findOrFail($productId);
        $path= $request->file('image')->store('productImages','public');
        $originalName=$request->file('image')->getClientOriginalName();

        $product->images()->create(
            [
                'path'=>$path,
                'orignal_name'=>$originalName

            ]
            );

         return  response()->json([
                'message'=>'Image uploaded successfully',
                'images'=>$product->fresh()->images,
            ]);


    }

    public function destroy($productId,$imageId)
    {
        $product =Product::findOrFail($productId);
        $image =$product->images()->findOrFail($imageId);
        if(Storage::disk('public')->exists($image->path)){
        Storage::disk('public')->delete($image->path);
        $image->delete();
        }

         return response()->json(
            [
            'message' => 'Image deleted successfully',
            'images'=>$product->fresh()->images,
            ]
        );
    }
}
