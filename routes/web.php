<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SocialAuthController;

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

Route::get('auth/github', [SocialAuthController::class, 'redirectToGithub'])->name('auth.github');
Route::get('auth/github/callback', [SocialAuthController::class, 'handleGithubCallback']);

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/category/{categoryId}', [ProductController::class, 'category'])->name('products.category');
Route::get('/api/cities/{province}', [LocationController::class, 'getCities'])->name('api.cities');

Route::middleware(['auth'])->group(function () {
    Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/seller/edit', [SellerController::class, 'edit'])->name('seller.edit');
    Route::put('/seller/update', [SellerController::class, 'update'])->name('seller.update');
    Route::get('/seller/products', [SellerController::class, 'products'])->name('seller.products');
    Route::delete('/seller/{id}', [SellerController::class, 'destroy'])->name('seller.destroy');
    Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
    Route::put('/seller/orders/{order}/update-status', [SellerController::class, 'updateOrderStatus'])->name('seller.orders.update-status');
    
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::post('/purchase/{purchase}/rate', [PurchaseController::class, 'rate'])->name('purchases.rate');
    Route::patch('/purchases/{purchase}/complete', [PurchaseController::class, 'complete'])->name('purchases.complete');
    Route::post('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
    
    Route::get('/cart', [PurchaseController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/update/{purchase}', [PurchaseController::class, 'updateCartItem'])->name('cart.update');
    Route::delete('/cart/remove/{purchase}', [PurchaseController::class, 'removeFromCart'])->name('cart.remove');
    Route::match(['get','post'],'/cart/checkout', [PurchaseController::class, 'checkoutFromCart'])->name('cart.checkout');
    Route::post('/cart/process', [PurchaseController::class, 'processCheckout'])->name('cart.process');
    Route::get('/cart/count', [PurchaseController::class, 'getCartCount'])->name('cart.count');
    Route::post('/cart/cancel-direct-purchase', [PurchaseController::class, 'cancelDirectPurchase'])->name('cart.cancel-direct-purchase');

    Route::get('/profile-index', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/search', [ProductController::class, 'searchProduct'])->name('admin.products.search');
    Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search');
    Route::get('/admin/users/{id}', [AdminController::class, 'viewUser'])->name('admin.users.view');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); 
    Route::get('/admin/purchases', [AdminController::class, 'purchases'])->name('admin.purchases');
    Route::get('/admin/purchases/{id}', [AdminController::class, 'viewPurchase'])->name('admin.purchases.view');
    Route::delete('/admin/purchases/{id}', [AdminController::class, 'deletePurchase'])->name('admin.purchases.delete');
    Route::get('/admin/purchases/search', [AdminController::class, 'searchPurchases'])->name('admin.purchases.search');
});

require __DIR__.'/auth.php';