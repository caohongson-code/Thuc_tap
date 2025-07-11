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
    public function show(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $query = Product::where('id_danhmuc', $id)
                          ->where('trang_thai', 'active')
                          ->with('category');
        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('search')) {
            $query->where('ten_san_pham', 'like', '%' . $request->search . '%');
        }
        // Lọc theo giá
        if ($request->sort == 'price_desc') {
            $query->orderBy('gia_coso', 'desc');
        } elseif ($request->sort == 'price_asc') {
            $query->orderBy('gia_coso', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $products = $query->paginate(12)->appends($request->all());
        $banners = Banner::all();
        return view('client.categories.show', compact('category', 'products', 'banners'));
    }
} 