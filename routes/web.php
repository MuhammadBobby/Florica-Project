<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserOrderController;
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
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::resource('customers', CustomerController::class);
    });


// ============ CUSTOMER ROUTES =============
Route::middleware(['auth'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/address', [CheckoutController::class, 'changeAddress'])->name('checkout.change-address');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/payment-callback', [CheckoutController::class, 'paymentCallback'])->name('checkout.payment-callback');

    // Adress
    Route::resource('my-addresses', UserAddressController::class)->only(['index', 'store', 'update', 'destroy']);

    // Orders
    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('my-orders.index');
    Route::post('/my-orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('my-orders.cancel');
});
