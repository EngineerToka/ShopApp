<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Product\ProductImagesController;
use App\Http\Controllers\Product\ProductReviewController;

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



});
// unAuthenticated routes

       // Product routes
    Route::apiResource('products', ProductsController::class)
     ->only(['index', 'show']);
      // Category routes
    Route::apiResource('categories',CategoryController::class)
          ->only(['index', 'show']);
         // user routes
     Route::post('register', [UserController::class,'register']);
     Route::post('login', [UserController::class,'login']);
