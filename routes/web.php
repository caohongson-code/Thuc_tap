<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;



// Route::get('/', function () {
//     return view('welcome');
// });

// Khu vực quản trị (admin)
Route::prefix('admin')->group(function () {
    Route::resource('/products',       ProductController::class);
    Route::resource('/categories',     CategoryController::class);
    Route::resource('/banners',        BannerController::class);
    // Thêm các resource khác nếu cần
});


// Route::resource('/category', CategoryController::class);

