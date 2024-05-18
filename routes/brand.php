<?php 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\CouponController;

Route::get('/brands', [BrandController::class, 'index']);
Route::get('/brands/{id}', [BrandController::class, 'show']);


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/colors', [ColorController::class, 'index']);
Route::get('/colors/{id}', [ColorController::class, 'show']);

Route::get('/sizes', [SizeController::class, 'index']);
Route::get('/sizes/{id}', [SizeController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);


Route::middleware(['auth:sanctum', CheckRole::class . ':admin'])->group(function () {

    Route::resource('/products', ProductController::class)->except(['index', 'show', 'edit', 'create']);
    Route::resource('/sizes', SizeController::class)->except(['index', 'show', 'edit', 'create']);
    Route::resource('/colors', ColorController::class)->except(['index', 'show', 'edit', 'create']);
    Route::resource('/brands', BrandController::class)->except(['index', 'show', 'edit', 'create']);
    Route::resource('/categories', CategoryController::class)->except(['index', 'show', 'edit', 'create']);
    Route::resource('/coupons', CouponController::class)->except(['edit', 'create']);
    Route::resource('/contacts', ContactController::class)->except(['edit', 'create', 'update']);
});