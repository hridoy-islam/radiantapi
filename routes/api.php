<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;




// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
// Brands
Route::get('/brands', [BrandController::class, 'index']);
Route::get('/brands/{id}', [BrandController::class, 'show']);



Route::get('/products', [ProductController::class, 'index']);
Route::get('/orders', [OrderController::class, 'index']);

Route::get('/sizes', [SizeController::class, 'index']);
Route::get('/sizes/{id}', [SizeController::class, 'show']);

Route::get('/colors', [ColorController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


// Admin and User Common
Route::middleware(['auth:sanctum'])->group(function () {
    Route::patch('/user/{id}', [UserController::class, 'update']);
    Route::get('/user/{id}', [UserController::class, 'show']);
});


// Admin Routes
Route::middleware(['auth:sanctum', CheckRole::class . ':admin'])->group(function () {

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::patch('/categories/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('/brands', [BrandController::class, 'store']);
    Route::patch('/brands/{id}', [BrandController::class, 'update']);
    Route::delete('/brands/{id}', [BrandController::class, 'destroy']);

    Route::post('/sizes', [SizeController::class, 'store']);
    Route::patch('/sizes/{id}', [SizeController::class, 'update']);
    Route::delete('/sizes/{id}', [SizeController::class, 'destroy']);

    Route::post('/colors', [ColorController::class, 'store']);
    Route::patch('/colors/{id}', [ColorController::class, 'update']);
    Route::delete('/colors/{id}', [ColorController::class, 'destroy']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/update', [ProductController::class, 'update']);
    
});
// User Route
Route::middleware(['auth:sanctum', CheckRole::class . ':user'])->group(function () {

});


Route::fallback(function () {
    return response()->json(['error' => 'Route Not Found'], 404);
});
