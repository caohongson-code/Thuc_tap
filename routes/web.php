<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', function () {return view('client.cart');})->name('cart');
Route::get('/show/{id}', [HomeController::class, 'show'])->name('client.show');


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Khu vực quản trị (admin)
Route::prefix('admin')->group(function () {
    Route::resource('/products',       ProductController::class);
    Route::resource('/categories',     CategoryController::class);
    Route::resource('/banners',        BannerController::class);
    // Thêm các resource khác nếu cần
});


// Route::resource('/category', CategoryController::class);

