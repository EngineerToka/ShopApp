<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
     use RefreshDatabase;

   public function test_user_can_place_order(){
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $product = Product::factory()->create(
        ['user_id' => $user->id,
         'quantity' => 10,
         'price' => 100,
        ]
    );
    $payLoad=[
        'items'=>[
            [
          'product_id'=>$product->id,
            'quantity'=>2,
            ],
        ]
        ];

     $response = $this->postJson('/api/orders',$payLoad)->assertStatus(201)->assertJson(['success' => true]);
        // $response->dump();
        $order =Order::first();
        $this->assertNotNull($order);

        $this->assertEquals(8, $product->fresh()->quantity);
        $this->assertEquals(200, $order->total);

    

   }
}
