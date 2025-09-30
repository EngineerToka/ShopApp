<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Product\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
   public function test_user_can_place_order(){
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
    $produts = Product::factory()->count(5)->create(
        ['user_id' => $user->id]
    );
    $payLoad=[
        'items'=>[
          'product_id'=>$produts->random()->id,
            'quantity'=>2,
        ]
        ];

     $response = $this->postJson('/api/orders',$payLoad)->assertStatus(200)->assertJson(['success' => true]);
        $response->dump();
    

   }
}
