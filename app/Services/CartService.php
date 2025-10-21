<?php

namespace App\Services;

use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Cart\CartItem;
use App\Services\OrderService;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;


class CartService
{

     public function getUserCart()
    {
        $user = Auth::user();
        return Cart::with(['items.product', 'coupon'])
            ->firstOrCreate(['user_id' => $user->id]);
    }

    public function addToCart(array $validated)
    {
        $user= Auth::user();

       $cart = Cart::firstOrCreate([
            'user_id'=>$user->id
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $item = $cart->cartItems()->where('product_id',$product->id)->first();

        if($item){
             $item->increment('quantity',$validated['quantity']);
        }else{
            $cart->cartItems()->create([
                'product_id'=>$product->id,
                'quantity'=>$validated['quantity'],
            ]);
        }

        return $cart->load('cartItems.product');


    }

    public function applyCoupon(Cart $cart,string $code){
        
        $coupon = Coupon::where('code',$code)->where('active',true)
        ->where('expires_at','>',now())->firstOrFail();

        $cart->update([
            'coupon_id'=>$coupon->id,
        ]);

        return  $coupon;
        
    }

    public function calculateTotals(Cart $cart){
        $subTotal = $cart->cartItems->sum(fn($i) =>($i->product->discount_price ?? $i->product->price) * $i->quantity);
        $discount=0;
        $coupon = $cart->coupon_id ? Coupon::find($cart->coupon_id) : null;
        if($coupon->type == 'fixed'){
            $discount=$coupon->value;
        }elseif($coupon->type == 'percent'){
            $discount= ($coupon->value/100) * $subTotal;
        }

        $total = max($subTotal - $discount, 0);

        return compact('subTotal','total','discount');
        
    }

    public function checkout(){
     $orderService= app(OrderService::class); 
     

     $user= Auth::user();
     $cart = Cart::with(['cartItems.product','coupon'])->where('user_id',$user->id)->firstOrFail();
       if ($cart->cartItems->isEmpty()) {
            throw new \RuntimeException('Cart is empty.');
        }
         $total =$this->calculateTotals($cart);

        $validated= [
         'items'=>$cart->cartItems->map(fn($i)=>[
                    'product_id' => $i->product->id,
                    'quantity'   => $i->quantity,
        
         ])->toArray(),
                'subtotal'=>$total['subTotal'],
                'discount'=>$total['discount'],
                'total'=> $total['total'],
                'coupon_id'=> $cart->coupon_id,
         ];

        $order= $orderService->createOrder($validated);
         $cart->cartItems()->delete();
         $cart->update(['coupon_id'=>null]);

        return $order;
    }

 public function removeItem(int $itemId)
    {
        $user = Auth::user();
        $cartItem = CartItem::where('id', $itemId)
            ->whereHas('cart', fn($q) => $q->where('user_id', $user->id))
            ->firstOrFail();

        $cartItem->delete();
        return true;
    }

}