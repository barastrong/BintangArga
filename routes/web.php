<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CartController;


Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::post('/purchase/{purchase}/rate', [PurchaseController::class, 'rate'])->name('purchases.rate');

    // Carts Route
    Route::get('/cart', [PurchaseController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/update/{purchase}', [PurchaseController::class, 'updateCartItem'])->name('cart.update');
    Route::post('/cart/remove/{purchase}', [PurchaseController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/checkout', [PurchaseController::class, 'checkoutFromCart'])->name('cart.checkout');
    Route::post('/cart/process', [PurchaseController::class, 'processCheckout'])->name('cart.process');
    Route::get('/cart/count', [PurchaseController::class, 'getCartCount'])->name('cart.count');
    Route::post('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';