<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Product\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $cartService;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->cartService = app(CartService::class);
    }

    /** @test */
    public function it_adds_a_product_to_cart()
    {
        $product = Product::factory()->create();
        $this->cartService->addToCart([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function it_increments_quantity_if_product_already_in_cart()
    {
        $product = Product::factory()->create();

        $this->cartService->addToCart([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->cartService->addToCart([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 4,
        ]);
    }
}
