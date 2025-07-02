<?php
namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product; 
use App\Models\Category;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request) 
{
    $query = Product::with('category');

    if ($request->has('search') && $request->search != '') {
        $query->where('ten_san_pham', 'like', '%' . $request->search . '%');
    }

    // Kết quả sản phẩm phân trang (đúng kết quả tìm kiếm nếu có)
    $products = $query->orderBy('id', 'desc')
                      ->paginate(8)
                      ->appends($request->only('search'));

    // Chỉ hiện sản phẩm hot nếu KHÔNG tìm kiếm
    $latestProducts = ($request->has('search') && $request->search != '')
        ? collect()
        : Product::orderBy('id', 'desc')->take(4)->get();

    $banners = Banner::all();

    return view('client.Home', compact('products', 'latestProducts', 'banners'));
}



public function show($id)
{
    $product = Product::with('category')->findOrFail($id);

    // Lấy các sản phẩm tương tự cùng danh mục, loại trừ sản phẩm hiện tại
    $relatedProducts = Product::where('id_danhmuc', $product->id_danhmuc)
                              ->where('id', '!=', $product->id)
                              ->take(4) // lấy 4 sản phẩm tương tự
                              ->get();
    
    return view('client.chitiet', compact('product', 'relatedProducts'));
}
public function banner(){
    $banner= Banner::where('trang_thai', 'active')->get();
    return view('client.layouts.main', compact('banner'));
}
}
