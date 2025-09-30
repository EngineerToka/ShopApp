<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Order\Coupon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CouponTest extends TestCase
{
    use RefreshDatabase; 

   public function test_admin_can_create_coupon()
   {
    $admin = User::factory()->create( ['role'=>'admin']);
    $this->actingAs($admin,'sanctum');
     $copoun = Coupon::factory()->raw();

     $response = $this->postJson('/api/coupons',$copoun)->assertStatus(201)->assertJson(['success' => true]);
     $response->dump();

   }
}
