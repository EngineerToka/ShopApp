<?php

namespace App\Http\Controllers\Cart;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
          $this->cartService = $cartService;
    }

    public function removeItem($id)
    {
       $cart= $cartService->getUserCart();
       $item = $cart->cartItems()->where('id',$id)->firstOrFail();
       $item->delete();  
       
       return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully.',
            'data' => []
        ]);
        
    }
}
