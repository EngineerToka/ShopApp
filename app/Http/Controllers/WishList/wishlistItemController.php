<?php

namespace App\Http\Controllers\WishList;

use Illuminate\Http\Request;
use App\Services\WishlistService;
use App\Http\Controllers\Controller;

class wishlistItemController extends Controller
{
    protected $wishlistService;

    public function __construct(WishlistService $wishlistService)
    {
          $this->wishlistService = $wishlistService;
    }

    public function removeItem($id)
    {
        $this->wishlistService->remove($id);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist successfully.',
            'data' => []
        ]);
        
    }
}
