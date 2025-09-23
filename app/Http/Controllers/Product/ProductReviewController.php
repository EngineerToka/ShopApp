<?php

namespace App\Http\Controllers\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductReviewRequest;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($productId)
    {
        $product = Product::findOrFail($productId);

        $reviews = $product->reviews()->with('user')->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' =>'Product reviews retrieved successfully',
            'data' =>  ProductReviewResource::collection($reviews),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductReviewRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $reviewExists = ProductReview::where('product_id',$product->id)
                         ->where('user_id',Auth::id())->exists();
        if($reviewExists){
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.',
            ], 409);
        } else {
            $review = ProductReview::create($request->validated() + ['product_id' => $product->id, 'user_id' => Auth::id()]);
            return response()->json([
                'success' => true,
                'message' => 'Review added successfully.',
                'data' => new ProductReviewResource($review->load('user')),
            ], 201);
        }

        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($productId, $reviewId)
    {
        $product = Product::findOrFail($productId);
        $review =ProductReview::where('product_id',$product->id)->findOrFail($reviewId);

        return response()->json([
            'success' => true,
            'message' => 'Review retrieved successfully.',
            'data' => new ProductReviewResource($review->load('user')),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductReviewRequest $request, $productId, $reviewId)
    {
        $product = Product::findOrFail($productId);

            $review = ProductReview::findOrFail($reviewId);

            if($review->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            
            $review->update($request->validated() + ['product_id' => $product->id, 'user_id' => Auth::id()]);

            return response()->json([
                'success' => true,
                'message' => 'Review Updated successfully.',
                'data' => new ProductReviewResource($review->load('user')),
            ], 201);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId, $reviewId)
    {
        $review = ProductReview::where('product_id',$productId)->findOrFail($reviewId);

        if($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->delete();

            return response()->json([
                    'success' => true,
                    'message' => 'Review deleted successfully',
                    'data' => null,
                ], 200);
    }
}
