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
Route::get('/posts', [BlogPostController::class, 'index']);


// Admin and User Common
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/user', UserController::class)->except(['edit', 'create', 'destroy']);
    Route::resource('/contact', ContactController::class)->except(['edit', 'create', 'destroy']);
    Route::resource('/finance', FinanceApplicantController::class)->except(['edit', 'create', 'destroy']);
    Route::resource('/sellcar', SellYourCarController::class)->except(['edit', 'create', 'destroy']);
    Route::resource('/tradecar', TradeYourCarController::class)->except(['edit', 'create', 'destroy']);
});


Route::fallback(function () {
    return response()->json(['message' => 'HTTP method not allowed for this route.'], 405);
});
 
