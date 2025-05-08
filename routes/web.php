<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;  
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('home');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/search', [ProductController::class, 'search']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');


Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
Route::delete('/products', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
Route::post('/products/update', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

