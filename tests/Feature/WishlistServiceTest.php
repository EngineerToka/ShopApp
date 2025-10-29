<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User\User;
use App\Models\Product\Product;
use App\Models\WishList\WishListItem;
use App\Services\WishlistService;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WishlistServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $wishlistService;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->wishlistService = app(WishlistService::class);
    }
    /** @test */
    public function it_adds_a_product_to_wishlist()
    {
        $product = Product::factory()->create();

        $wishlist = $this->wishlistService->add([
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseHas('wishlist_items', [
            'product_id' => $product->id,
        ]);
    }

    /** @test */
    public function it_moves_item_from_wishlist_to_cart()
    {
        $product = Product::factory()->create();
        $wishlist = $this->wishlistService->add([
            'product_id' => $product->id,
        ]);

        $item = $wishlist->wishlistItems()->first();

        $this->wishlistService->addToCart($item->id);

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseMissing('wishlist_items', [
            'id' => $item->id,
        ]);
    }
}
