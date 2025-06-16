<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserController;
use Laravel\Sanctum\HasApiTokens;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->group(function(){
    Route::get('/', [ProductApiController::class, 'index']);
    Route::post('/store', [ProductApiController::class, 'store']);
    Route::get('/show/{id}', [ProductApiController::class, 'show']);
    Route::delete('/delete/{id}', [ProductApiController::class, 'destroy']);
});

Route::prefix('users')->group(function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/store', [UserController::class, 'store']);
    Route::get('/show/{user}', [UserController::class, 'show']);
    Route::delete('/delete/{user}', [UserController::class, 'destroy']);
    Route::put('/update/{user}', [UserController::class, 'update']);
});