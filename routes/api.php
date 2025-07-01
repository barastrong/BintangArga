<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\AuthController;
use Laravel\Sanctum\HasApiTokens;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/
Route::prefix('products')->group(function(){
    Route::get('/', [ProductApiController::class, 'index']);
    Route::post('/store', [ProductApiController::class, 'store']);
    Route::get('/show/{id}', [ProductApiController::class, 'show']);
    Route::delete('/delete/{id}', [ProductApiController::class, 'destroy']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (memerlukan authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // User routes dengan prefix dan custom naming
    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/show/{user}', [UserController::class, 'show']);
        Route::delete('/delete/{user}', [UserController::class, 'destroy']);
        Route::put('/update/{user}', [UserController::class, 'update']);
    });
});