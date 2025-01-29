<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/{product}', [CartController::class, 'remove']);

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'store'])->name('order.store');
    Route::get('/commande/success', [OrderController::class, 'succes'])->name('order.succes');
    Route::delete('/cart/{product}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Routes pour les avis
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Routes pour les coupons
Route::post('/cart/apply-coupon', [CouponController::class, 'apply'])->name('coupons.apply');


// Routes pour l'administration
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';
