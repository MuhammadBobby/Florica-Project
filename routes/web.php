<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ============= MAIN ROUTES =============
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/products/{slug}', [HomeController::class, 'productDetail'])->name('product.detail');

// ============= AUTH ROUTES =============
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

// ============== DASHBOARD ROUTES =============
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
