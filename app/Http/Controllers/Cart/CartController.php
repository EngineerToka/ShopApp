<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CopounResource;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
          $this->cartService = $cartService;
    }

    public function index()
    {
       $cart= $cartService->getUserCart();

        return response()->json([
            'success' => true,
            'message' => 'Cart retrieved successfully.',
            'data' => new CartResource($cart)
        ]);
    }


    public function store(CartItemRequest $request)
    {
         $cart= $cartService->addToCart($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully.',
                'data' => new CartResource($cart)
            ], 201);
    }

    public function applyCoupon(CartRequest $request)
    {
        $cart = $cartService->getUserCart();
        $coupon= $cartService->applyCoupon($cart,$request->code);

        return response()->json( [
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'data' => new CopounResource($coupon),
        ]);
    }

    public function checkout()
    {
         $order = $cartService->checkout();

         return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data' => new OrderResource($order),
        ]);
    }

    public function clearCart()
    {
        $cart = $cartService->getUserCart();
        $cart->cartItems()->delete();
        $cart->update(['coupon_id' => null]);
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
        ]);
    }

}
