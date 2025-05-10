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

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');

Route::get('/delivery', [App\Http\Controllers\DeliveryController::class, 'index'])->name('delivery');
Route::post('/orders', [App\Http\Controllers\DeliveryController::class, 'store'])->name('orders.store');
Route::get('/order/confirmation/{id}', [App\Http\Controllers\DeliveryController::class, 'confirmation'])->name('order.confirmation');

