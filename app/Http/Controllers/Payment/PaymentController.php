<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $paymentService;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService =  $paymentService;
    }
    public function createCheckOut(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $session = $this->paymentService->createCheckOut($order);
        return response()->json(['url' => $session->url]);

    }
    public function Webhook(Request $request)
    {
        $payload = Order::findOrFail($request->order_id);
        $service = $this->paymentService->handleWebhook($payload);
        return response()->json(['status' => 'Sucessfully processed webhook event.']);

    }


}
