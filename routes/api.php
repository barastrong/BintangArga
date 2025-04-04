<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product API routes
Route::get('/products', [ProductApiController::class, 'index']);
Route::post('/products/store', [ProductApiController::class, 'store']);
Route::get('/products/show/{id}', [ProductApiController::class, 'show']);
Route::delete('/products/delete/{id}', [ProductApiController::class, 'destroy']);