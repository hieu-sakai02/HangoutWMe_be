<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CoffeeShopController;
use App\Http\Controllers\API\FavCoffeeShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('users')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::put('update', [AuthController::class, 'update'])->middleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::get('google', [AuthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);
    // Add other auth-related routes
});

/*
|--------------------------------------------------------------------------
| Coffee Shop Routes
|--------------------------------------------------------------------------
*/
Route::prefix('coffee-shops')->group(function () {
    Route::get('/', [CoffeeShopController::class, 'index']);
    Route::get('/{id}', [CoffeeShopController::class, 'show']);
    Route::post('/', [CoffeeShopController::class, 'store']);
    Route::put('/{id}', [CoffeeShopController::class, 'update']);
    Route::delete('/{id}', [CoffeeShopController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Favorite Coffee Shop Routes
|--------------------------------------------------------------------------
*/
Route::prefix('favorite-coffee-shops')->group(function () {
    Route::get('/user/{userId}', [FavCoffeeShopController::class, 'getByUser']);
    Route::post('/', [FavCoffeeShopController::class, 'store']);
    Route::put('/user/{userId}/coffee-shop/{coffeeShopId}', [FavCoffeeShopController::class, 'update']);
});
