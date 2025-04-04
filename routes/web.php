<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;


Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/category/{categoryId}', [ProductController::class, 'category'])->name('products.category');

Route::middleware(['auth'])->group(function () {
    Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/seller/edit', [SellerController::class, 'edit'])->name('seller.edit');
    Route::put('/seller/update', [SellerController::class, 'update'])->name('seller.update');
    Route::get('/seller/products', [SellerController::class, 'products'])->name('seller.products');

    // New orders routes
    Route::get('/seller/orders', [SellerController::class, 'orders'])->name('seller.orders');
    Route::put('/seller/orders/{order}/update-status', [SellerController::class, 'updateOrderStatus'])->name('seller.orders.update-status');
    
    // Product 
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::post('/purchase/{purchase}/rate', [PurchaseController::class, 'rate'])->name('purchases.rate');

    // Admin Routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/search', [ProductController::class, 'searchProduct'])->name('admin.products.search');
    Route::get('/admin/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search');
    Route::get('/admin/users/{id}', [AdminController::class, 'viewUser'])->name('admin.users.view');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete'); 

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