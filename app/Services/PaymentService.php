<?php
namespace App\Services;

use Stripe\Stripe;
use App\Models\Order\Order;
use Stripe\Checkout\Session;

class PaymentService
{

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
    }


    public function createCheckOut($order){
        
         $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . $order->id,
                    ],
                    'unit_amount' => $order->total , // in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/api/payment/success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/api/payment/cancel'),
        ]);

        return $session;

    }

     public function handleWebhook($payload)
    {
        if ($payload['type'] === 'checkout.session.completed') {
            $session = $payload['data']['object'];
            $orderId = explode('#', $session['display_items'][0]['custom']['name'])[1] ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->update(['status' => 'paid']);
                }
            }
        }
    }
}