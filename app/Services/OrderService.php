<?php

namespace App\Services;

use App\Models\Order\Order;
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
                $total = $subtotal- $discount;

                $order->update([
                'subtotal'=>$subtotal,
                'discount'=>$discount,
                'total'=>  $total ,
                ]);
               
            
                    return $order->fresh()->load(['items.product','user']);
        });

    }
}