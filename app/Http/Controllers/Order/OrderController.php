<?php

namespace App\Http\Controllers\Order;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service =$service;
    }



    public function index()
    {
        $orders = Order::with('orderItems.product','user')->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Orders retrieved successfully.',
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(OrderRequest $request)
    {
      $order= $this->service->createOrder($request->validated());
         return response()->json([
          'success' => true,
          'message' => 'Order created successfully.',
          'data'=> new OrderResource($order),
         ],201);

    }

    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function updateStatus(updateOrderStatusRequest $request, $orderId)
    {
        $order =Order::findOrFail($orderId);

        if($order->status ==='pending' && $request->status == 'cancelled'){
            foreach($order->orderItems as $item){
                $item->product->increment('quantity',$item->quantity);
            }
            $order->update(['status'=>$request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Order status cancelled successfully.',
                'data' => new OrderResource($order),
            ], 200);
            
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Only pending orders can be cancelled.',
            ], 400);
        }
        
    }
    public function cancelOrder(Request $request, $id)
    {
        //
    }
}
