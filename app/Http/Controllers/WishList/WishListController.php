<?php

namespace App\Http\Controllers\WishList;

use Illuminate\Http\Request;
use App\Services\WishlistService;
use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistRequest;
use App\Http\Resources\WishlistResource;
use App\Http\Requests\WishlistItemRequest;

class WishListController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
          $this->wishlistService = $wishlistService;
    }

    public function index()
    {
       $wishlist= $this->wishlistService->getUserWishlist();

        return response()->json([
            'success' => true,
            'message' => 'wishlist retrieved successfully.',
            'data' => new WishlistResource($wishlist)
        ]);
    }


    public function store(WishlistItemRequest $request)
    {
         $wishlist= $this->wishlistService->add($request->validated);
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully.',
                'data' => new WishlistResource($wishlist)
            ], 201);
    }

    public function addToCart($itemId)
    {
         $response= $this->wishlistService->addToCart($itemId);
    

        return response()->json( [
            'success' => true,
            'message' => $response['message'],
            'data' => [],
        ]);
    }


    public function clearWishlist()
    {
        $wishlist = $this->wishlistService->getUserWishlist();
        $wishlist->wishlistItems()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared successfully.',
        ]);
    }

}
