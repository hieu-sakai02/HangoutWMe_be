<?php

use App\Http\Controllers\API\AuthController;
// Import other controllers here, for example:
// use App\Http\Controllers\API\UserController;
// use App\Http\Controllers\API\ProductController;
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
    Route::get('google', [AuthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);
    // Add other auth-related routes
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
// Example for a UserController
// Route::controller(UserController::class)->prefix('users')->group(function () {
//     Route::get('/', 'index');
//     Route::get('/{id}', 'show');
//     Route::put('/{id}', 'update');
//     Route::delete('/{id}', 'destroy');
// });

/*
|--------------------------------------------------------------------------
| Other Controller Routes
|--------------------------------------------------------------------------
*/
// Example for another controller
// Route::controller(ProductController::class)->prefix('products')->group(function () {
//     Route::get('/', 'index');
//     Route::post('/', 'store');
//     Route::get('/{id}', 'show');
//     // etc.
// });