<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckRole;



use App\Http\Controllers\OrderController;

use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;


require __DIR__ . '/brand.php';

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [AuthController::class, 'reset']);



// Admin and User Common
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::patch('/user/{id}', [UserController::class, 'update']);
    Route::get('/user/{id}', [UserController::class, 'show']);
});


// Admin Routes
Route::middleware(['auth:sanctum', CheckRole::class . ':admin'])->group(function () {
    
    
    
});
// User Route
Route::middleware(['auth:sanctum', CheckRole::class . ':user'])->group(function () {

});