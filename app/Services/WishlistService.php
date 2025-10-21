<?php

namespace App\Services;

use App\Services\CartService;
use App\Models\Product\Product;
use App\Models\WishList\WishList;


class WishlistService
{
  protected $cartService;

  public function __construct(CartService $cartService){

    $this->cartService=$cartService;

  }

   public function getUserWishlist()
    {
        $user = Auth::user();
        return Wishlist::with('items.product')
            ->firstOrCreate(['user_id' => $user->id]);
    }

  public function add(array $validated){
    $user = Auth::user();
    $wishlist = Wishlist::firstOrCreate(['user_id' => $user->id]);
    $product = Product::findOrFail($validated['product_id']);
    $exists = $wishlist->wishlistItems()->where('product_id',  $product->id)->exists();

    if(!$exists){
      $wishlist->wishlistItems->create([
        'product_id' => $product->id,
      ]);
    }

    return $wishlist->load('wishlistItems.product');

  }

  public function addToCart($itemId){
     $wishlistItems = wishlistItems::with('product')->findOrFail($itemId);
     $this->cartService->addToCart([
        'product_id'=>$wishlistItems->id,
        'quantity'=>1,
     ]);
     
     $wishlistItems->delete();

     return response()->json(['message' => 'Item moved to cart successfully']);
     

  }

      public function remove(int $itemId)
    {
        $user = Auth::user();
        $item = WishlistItem::where('id', $itemId)
            ->whereHas('wishlist', fn($q) => $q->where('user_id', $user->id))
            ->firstOrFail();
        $item->delete();
    }
}