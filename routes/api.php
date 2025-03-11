<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\FetchController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get('/users/me', [AuthController::class, 'getUserDetails']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/categories/{category_id?}', [FetchController::class, 'getCategories']);
    Route::get('/products/search', [FetchController::class, 'searchProducts'])->middleware('validateUser');
    Route::post('/cart/add', [CommonController::class, 'addToCart'])->middleware('validateUser');
    Route::delete('/cart/remove', [CommonController::class, 'removeFromCart'])->middleware('validateUser');
    Route::get('/cart/products', [CommonController::class, 'getCartProducts'])->middleware('validateUser');
    Route::get('/sliders', [FetchController::class, 'getSliders'])->middleware('validateUser');
    Route::get('/brand-sliders', [FetchController::class, 'getBrandSliders'])->middleware('validateUser');
    Route::post('/orders', [CommonController::class, 'order'])->middleware('validateUser');
    Route::get('/orders', [FetchController::class, 'getOrders'])->middleware('validateUser');
});
