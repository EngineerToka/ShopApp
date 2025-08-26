<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Product\ProductImagesController;

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

Route::middleware('auth:sanctum')->group(function () {
    // Product routes
    Route::apiResource('product', ProductsController::class)
         ->only(['store', 'update', 'destroy']);
     // Product images routes
    Route::prefix('products')->group(function(){
        Route::get('{productId}/images',[ProductImagesController::class,'index']);
        Route::post('{productId}/images',[ProductImagesController::class,'store']);
        Route::delete('{productId}/images/{$imageId}',[ProductImagesController::class,'destroy']);
    });
});

Route::apiResource('products', ProductsController::class)
     ->only(['index', 'show']);