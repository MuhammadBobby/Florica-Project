<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ============= MAIN ROUTES =============
Route::get('/', [HomeController::class, 'index'])->name('landing');
Route::get('/products', [HomeController::class, 'products'])->name('products');

// ============= AUTH ROUTES =============
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
