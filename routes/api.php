<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product API routes
Route::get('/products', [ProductApiController::class, 'index']);
Route::post('/products/store', [ProductApiController::class, 'store']);
Route::get('/products/show/{id}', [ProductApiController::class, 'show']);
Route::delete('/products/delete/{id}', [ProductApiController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users/store', [UserController::class, 'store']);
Route::get('/users/show/{id}', [UserController::class, 'show']);
Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
Route::put('/users/update/{id}', [UserController::class, 'update']);