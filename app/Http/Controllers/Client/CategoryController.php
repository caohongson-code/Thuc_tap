<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;

class CategoryController extends Controller
{
    // Hiển thị tất cả danh mục
    public function index()
    {
        $categories = Category::where('trang_thai', 'active')->get();
        $banners = Banner::all();
        return view('client.categories.index', compact('categories', 'banners'));
    }

    // Hiển thị sản phẩm theo danh mục
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('id_danhmuc', $id)
                          ->where('trang_thai', 'active')
                          ->with('category')
                          ->paginate(12);
        $banners = Banner::all();
        return view('client.categories.show', compact('category', 'products', 'banners'));
    }
} 