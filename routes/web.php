<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// ============= MAIN ROUTES =============
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

// ============= AUTH ROUTES =============
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerStore'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ============== DASHBOARD ROUTES (ADMIN) =============
Route::middleware(['auth', 'role:admin'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/store-profile', [DashboardController::class, 'storeProfile'])->name('store-profile.index');
        Route::put('/store-profile', [DashboardController::class, 'updateStoreProfile'])->name('store-profile.update');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('customers', CustomerController::class);
    });
