<?php

namespace App\Http\Controllers\WishList;

use Illuminate\Http\Request;
use App\Services\WishlistService;

class wishlistItemController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
          $this->wishlistService = $wishlistService;
    }

    public function removeItem($id)
    {
       $wishlist= $wishlistService->getUserWishlist();
       $item = $wishlist->wishlistItems()->where('id',$id)->firstOrFail();
       $item->delete();  
       
       return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist successfully.',
            'data' => []
        ]);
        
    }
}
