<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\Admin\AdminApprovalController;

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

    Route::prefix('seller')->name('seller.')->group(function() {
        Route::get('/register', [SellerController::class, 'create'])->name('register');
        Route::post('/register', [SellerController::class, 'store'])->name('store');
        Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
        Route::get('/edit', [SellerController::class, 'edit'])->name('edit');
        Route::put('/update', [SellerController::class, 'update'])->name('update');
        Route::get('/products', [SellerController::class, 'products'])->name('products');
        Route::delete('/{id}', [SellerController::class, 'destroy'])->name('destroy');
        Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
        Route::put('/orders/{order}/update-status', [SellerController::class, 'updateOrderStatus'])->name('orders.update-status');
    });

    Route::prefix('delivery')->name('delivery.')->group(function(){
        Route::get('/register', [DeliveryController::class, 'register'])->name('register');
        Route::post('/register', [DeliveryController::class, 'storeRegister'])->name('register.store');
        Route::get('/dashboard', [DeliveryController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [DeliveryController::class, 'orders'])->name('orders');
        Route::get('/orders/{id}', [DeliveryController::class, 'orderDetail'])->name('order-detail');
        Route::patch('/orders/{id}/update-status', [DeliveryController::class, 'updateOrderStatus'])->name('update-status');
        Route::get('/profile', [DeliveryController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [DeliveryController::class, 'editProfile'])->name('edit-profile');
        Route::patch('/profile', [DeliveryController::class, 'updateProfile'])->name('update-profile');
        Route::get('/history', [DeliveryController::class, 'history'])->name('history');
    });
    
    
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
});

Route::middleware('auth', 'verified')->group(function () {
    Route::prefix('purchase')->name('purchases.')->group(function() {
        Route::get('/purchase', [PurchaseController::class, 'index'])->name('index');
        Route::post('/store', [PurchaseController::class, 'store'])->name('store');
        Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('show');
        Route::post('/{purchase}/rate', [PurchaseController::class, 'rate'])->name('rate');
        Route::patch('/{purchase}/complete', [PurchaseController::class, 'complete'])->name('complete');
        Route::post('/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('cancel');
    });
    Route::prefix('cart')->name('cart.')->group(function() {
        Route::get('/', [PurchaseController::class, 'viewCart'])->name('index');
        Route::post('/update/{purchase}', [PurchaseController::class, 'updateCartItem'])->name('update');
        Route::delete('/remove/{purchase}', [PurchaseController::class, 'removeFromCart'])->name('remove');
        Route::match(['get','post'],'/checkout', [PurchaseController::class, 'checkoutFromCart'])->name('checkout');
        Route::post('/process', [PurchaseController::class, 'processCheckout'])->name('process');
        Route::get('/count', [PurchaseController::class, 'getCartCount'])->name('count');
        Route::post('/cancel-direct-purchase', [PurchaseController::class, 'cancelDirectPurchase'])->name('cancel-direct-purchase');    
    });

    Route::prefix('profile')->name('profile.')->group(function() {    
        Route::get('-index', [ProfileController::class, 'index'])->name('index');
        Route::get('-edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('-update', [ProfileController::class, 'update'])->name('update');
        Route::delete('-destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/products/search', [ProductController::class, 'searchProduct'])->name('products.search');
        Route::get('/users/search', [AdminController::class, 'searchUsers'])->name('users.search');
        Route::get('/users/{id}', [AdminController::class, 'viewUser'])->name('users.view');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete'); 
        Route::get('/purchases', [AdminController::class, 'purchases'])->name('purchases');
        Route::get('/purchases/{id}', [AdminController::class, 'viewPurchase'])->name('purchases.view');
        Route::delete('/purchases/{id}', [AdminController::class, 'deletePurchase'])->name('purchases.delete');
        Route::get('/purchases/search', [AdminController::class, 'searchPurchases'])->name('purchases.search');
        Route::get('/sellers', [AdminController::class, 'sellers'])->name('sellers');
        Route::get('/sellers/{id}', [AdminController::class, 'viewSeller'])->name('sellers.view');
        Route::get('/sellers/search', [AdminController::class, 'searchSellers'])->name('sellers.search');
        Route::delete('/sellers/{id}', [AdminController::class, 'deleteSeller'])->name('sellers.delete');
        Route::get('/deliveries', [AdminController::class, 'deliveries'])->name('deliveries');
        Route::get('/deliveries/{id}', [AdminController::class, 'viewDelivery'])->name('deliveries.view');
        Route::get('/deliveries/search', [AdminController::class, 'searchDeliveries'])->name('deliveries.search');
        Route::delete('/deliveries/{id}', [AdminController::class, 'deleteDelivery'])->name('deliveries.delete');
            // Delivery Approval Routes
    Route::get('/approvals/deliveries', [AdminApprovalController::class, 'deliveryApprovals'])
        ->name('approvals.deliveries');
    
    Route::get('/approvals/deliveries/search', [AdminApprovalController::class, 'searchDeliveries'])
        ->name('approvals.deliveries.search');
    
    Route::post('/approvals/delivery/{id}/approve', [AdminApprovalController::class, 'approveDelivery'])
        ->name('approvals.delivery.approve');
    
    Route::post('/approvals/delivery/{id}/reject', [AdminApprovalController::class, 'rejectDelivery'])
        ->name('approvals.delivery.reject');

    // Seller Approval Routes
    Route::get('/approvals/sellers', [AdminApprovalController::class, 'sellerApprovals'])
        ->name('approvals.sellers');
    
    Route::get('/approvals/sellers/search', [AdminApprovalController::class, 'searchSellers'])
        ->name('approvals.sellers.search');
    
    Route::post('/approvals/seller/{id}/approve', [AdminApprovalController::class, 'approveSeller'])
        ->name('approvals.seller.approve');
    
    Route::post('/approvals/seller/{id}/reject', [AdminApprovalController::class, 'rejectSeller'])
        ->name('approvals.seller.reject');
    });
});

require __DIR__.'/auth.php';