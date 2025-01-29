<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\User\UserProductController;
use App\Http\Controllers\Api\User\UserOrderController;
use App\Http\Controllers\Api\User\UserReviewController;

// Routes publiques
Route::post('/login', [AuthController::class, 'login']);

// Routes pour les utilisateurs authentifiés
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes pour les utilisateurs standard
    Route::prefix('user')->group(function () {
        Route::get('/products', [UserProductController::class, 'index']);
        Route::get('/products/{product}', [UserProductController::class, 'show']);
        Route::get('/orders', [UserOrderController::class, 'index']);
        Route::get('/orders/{order}', [UserOrderController::class, 'show']);
        Route::get('/reviews', [UserReviewController::class, 'index']);
        Route::get('/reviews/{review}', [UserReviewController::class, 'show']);
    });

    // Routes pour les administrateurs
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/produits', [ProductApiController::class, 'index']);
        Route::post('/product/create', [ProductApiController::class, 'store']);
        Route::put('/products/modifier/{id}', [ProductApiController::class, 'update']);
        Route::apiResource('categories', CategoryApiController::class);
        Route::apiResource('orders', OrderApiController::class);
        Route::apiResource('reviews', ReviewApiController::class);
        Route::apiResource('users', UserApiController::class);
    });
}); 