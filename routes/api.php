<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;


use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\TradeYourCarController;
use App\Http\Controllers\SellYourCarController;
use App\Http\Controllers\FinanceApplicantController;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/cars', [CarController::class, 'index']);
Route::get('/cars/{slug}', [CarController::class, 'show']);
Route::get('/posts', [BlogPostController::class, 'index']);
Route::get('/posts/{slug}', [BlogPostController::class, 'show']);

Route::post('/contact', [ContactController::class, 'store']);
Route::post('/finance', [FinanceApplicantController::class, 'store']);
Route::post('/sellcar', [SellYourCarController::class, 'store']);
Route::post('/tradecar', [TradeYourCarController::class, 'store']);

// Admin and User Common
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/posts', BlogPostController::class)->except(['index', 'edit', 'create', 'destroy']);
    Route::resource('/user', UserController::class)->except(['edit', 'create', 'destroy']);
    Route::resource('/finance', FinanceApplicantController::class)->except(['store','edit', 'create', 'destroy']);
    Route::resource('/sellcar', SellYourCarController::class)->except(['store','edit', 'create', 'destroy']);
    Route::resource('/tradecar', TradeYourCarController::class)->except(['store','edit', 'create', 'destroy']);
    Route::resource('/cars', CarController::class)->except(['index', "show", 'edit', 'create',]);
    Route::get('/contact', [ContactController::class, 'index']);
});


Route::fallback(function () {
    return response()->json(['message' => 'HTTP method not allowed for this route.'], 405);
});
 
