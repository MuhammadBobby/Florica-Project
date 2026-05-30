<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// ============= MAIN ROUTES =============
Route::get('/', [HomeController::class, 'index'])->name('landing');
