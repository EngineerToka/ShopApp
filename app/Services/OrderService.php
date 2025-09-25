<?php

namespace App\Services;

use App\Models\Order\Order;
use App\Models\Order\Coupon;
use App\Models\Order\OrderItem;

class orderService
{
    public function createOrder(array $validatedData) :Order
    {
        $userId =Auth::id();

        return DB::transaction(function() use($userId,$validatedData) {

            $subtotal = 0;

            $order = Order::create([
                'status'=> 'pending',
                'user_id' =>$userId,
                'subtotal'=>0,
                'discount'=>0,
                'total'=> 0,
                'coupon_id'=> 0,
            ]);
            $total = 0;
            foreach($validatedData['items'] as $item){
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                $ProductQuantity = $product->quantity;
                $qty = (int) $item['quantity'];

                 if($ProductQuantity < $qty ){
                    throw new \RuntimeException("Insufficient stock for product ID: {$item['product_id']}");
                 }

            
            $price = $product->discount_price ?? ($product->price * (1 - $product->discount / 100));
            $itemTotal = $price * $qty ;

             OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'unit_price' => $price,
                    'total'      => $itemTotal,
                ]);
                  
                $product->decrement('quantity',$qty );
                $subtotal +=$itemTotal;

                   
            }
                $discount =0;
                $coupon = null;

                if (!empty($validatedData['coupon_code'])){
                    $coupon = Coupon::where('code',$validatedData['coupon_code'])->first();

                    if (!$coupon) {
                    throw new \RuntimeException("Invalid coupon code");
                       }

                    if($coupon->expires_at && $coupon->expires_at->isPast()){
                        throw new \RuntimeException("Coupon code has expired.");
                    }
                    if($coupon->active == false){
                         throw new \RuntimeException("Coupon is not active");
                    }
                    if($coupon->max_uses && $coupon->used_count >= $coupon->max_uses){
                         throw new \RuntimeException("Coupon usage limit reached");
                    }
                    if($coupon->min_order && $subtotal < $coupon->min_order ){
                         throw new \RuntimeException("Order does not meet minimum requirement for this coupon");
                    }
                }
                if($coupon->type === 'fixed'){
                    $discount = min($coupon->value, $subtotal); 
                }elseif ($coupon->type === 'percent'){
                    $discount = ($coupon->value/100)* $subtotal;
                }


                $total = $subtotal- $discount;

                $order->update([
                'subtotal'=>$subtotal,
                'discount'=>$discount,
                'total'=>  $total ,
                'coupon_id'=> $coupon->id ?? null,
                ]);
                $coupon->increment('used_count');


               
            
                    return $order->fresh()->load(['items.product','user','coupon']);
        });

    }
}