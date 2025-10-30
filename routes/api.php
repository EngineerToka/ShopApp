<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\CouponController;
use App\Http\Controllers\Cart\CartItemController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\WishList\WishListController;
use App\Http\Controllers\Product\ProductImagesController;
use App\Http\Controllers\Product\ProductReviewController;
use App\Http\Controllers\WishList\wishlistItemController;
use App\Http\Controllers\Product\stockManagementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::
// Get current authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('role:admin')->group(function(){
    // admin routes
        // Category routes
       Route::apiResource('categories',CategoryController::class)
         ->only(['store', 'update', 'destroy']);
        // user routes
       Route::apiResource('users',UserController::class)
       ->only(['index', 'show', 'store', 'update', 'destroy']); 
       // stock management routes
       Route::put('product/{productId}/stock',[stockManagementController::class,'update']);
       // order routes
       Route::prefix('orders')->group(function(){
       Route::delete('/{order_id}',[OrderController::class,'destroy']);
       Route::put('/{order_id}',[OrderController::class,'updateStatus']);
       Route::post('/',[OrderController::class,'store']);
       });
    // copoun routes
    Route::apiResource('coupons',CouponController::class);
});

Route::middleware('role:seller')->group(function(){
 // seller routes
    // Product routes
    Route::apiResource('product', ProductsController::class)
         ->only(['store', 'update', 'destroy']);
     // Product images routes
    Route::prefix('products')->group(function(){
        Route::post('{productId}/images',[ProductImagesController::class,'store']);
        Route::delete('{productId}/images/{imageId}',[ProductImagesController::class,'destroy']);
    });

});

Route::middleware('auth:sanctum')->group(function () {
    // product
    Route::apiResource('products', ProductsController::class)
     ->only(['index', 'show']);

      // Category routes
    Route::apiResource('categories',CategoryController::class)
          ->only(['index', 'show']);
          
    // user routes
     Route::prefix('user')->group(function(){
    Route::get('profile', [UserController::class,'profile']);
    Route::put('profile', [UserController::class,'update']);
    Route::post('logout', [UserController::class,'logout']);
    });

    //  review routes
    Route::prefix('products/{productId}')->group(function () {
    Route::get('reviews', [ProductReviewController::class,'index']);
    Route::post('reviews', [ProductReviewController::class,'store']);
    Route::put('reviews/{reviewId}', [ProductReviewController::class,'update']);
    Route::delete('reviews/{reviewId}', [ProductReviewController::class,'destroy']);
     });

    // order routes
    Route::prefix('orders')->group(function(){
        Route::get('/',[OrderController::class,'index']);
        Route::get('/{order_id}',[OrderController::class,'show']);
        Route::get('/{order_id}/cancel',[OrderController::class,'cancelOrder']);

    });

      // Cart Routes
  Route::prefix('cart')->group(function(){
    Route::get('/', [CartController::class, 'index']);
    Route::post('/add', [CartController::class, 'store']);
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon']);
    Route::post('/checkout', [CartController::class, 'checkout']);
    Route::delete('/clear', [CartController::class, 'clearCart']);
    // Cart Items
    Route::delete('/items/{id}', [CartItemController::class, 'removeItem']);
       });
       
    // Wishlist Routes
 Route::prefix('wishlist')->group(function(){
    Route::get('/', [WishListController::class, 'index']);
    Route::post('/add', [WishListController::class, 'store']);
    Route::post('/move-to-cart/{id}', [WishListController::class, 'addToCart']);
    Route::delete('/clear', [WishListController::class, 'clearWishlist']);
    // Wishlist Items
    Route::delete('/items/{id}', [wishlistItemController::class, 'removeItem']);
       });

    //    stripe payment routes
    Route::post('/payment/create', [PaymentController::class, 'createCheckOut']);
    Route::post('/payment/webhook', [PaymentController::class, 'Webhook']);


});

// unAuthenticated routes
       // Product routes
    Route::apiResource('products', ProductsController::class)
     ->only(['index', 'show']);
      // Category routes
    Route::apiResource('categories',CategoryController::class)
          ->only(['index', 'show']);
         // user routes
     Route::post('register', [UserController::class,'store']);
     Route::post('login', [UserController::class,'login']);
