<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', function () {
    return view('client.cart');
})->name('cart');

// Khu vực quản trị (admin)
Route::prefix('admin')->group(function () {
    Route::resource('/products',       ProductController::class);
    Route::resource('/categories',     CategoryController::class);
    Route::resource('/banners',        BannerController::class);
    // Thêm các resource khác nếu cần
});


// Route::resource('/category', CategoryController::class);

