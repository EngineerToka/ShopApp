<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $q = Product::with('images','category','user');

     if($user->role == 'seller'){
        $ProductResource = $q->where('user_id',$user->id);
          }

        if ($search = $request->query('search')) {
        $q->where(fn($qb) => $qb->where('title','like',"%{$search}%")
            ->orWhere('description','like',"%{$search}%"));
         }
    if ($cat = $request->query('category_id')) $q->where('category_id', $cat);
    if ($min = $request->query('min_price')) $q->where('price','>=',$min);
    if ($max = $request->query('max_price')) $q->where('price','<=',$max);
    if ($sort = $request->query('sort')) {
        $direction = $request->query('direction','desc');
        $q->orderBy($sort, $direction);
    }
    
  $ProductResource = $q->paginate($request->query('per_page', 20));
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
        $this->authorize('update', Product::class);

        $product = Product::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()]
        ));

        return response()->json([
             'success' => true,
             'message' => 'Product created successfully',
             'product' => new ProductResource($product),
            ],201);
    }

    public function show($id)
    {
      $product= Product::with('images','user','category')->findOrFail($id)->append('MainImage');
        $this->authorize('view', $product);
        
        return response()->json([
             'success' => true,
             'message' => 'Product retrieved successfully',
             'products' => new ProductResource($product),
            ],200);
    }

    public function edit($id)
    {
        //
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);

        $product->update(array_merge($request->validated(),[
            'user_id' => Auth::id()]
        ));
        return response()->json([
             'success' => true,
             'message' => 'Product updated successfully',
             'product' => new ProductResource($product) ,
            ],200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
          
        $this->authorize('delete', $product);
        
        $product->delete();

         return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ],200);
    }
}
