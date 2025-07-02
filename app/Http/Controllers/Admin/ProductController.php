<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variants', 'category')->orderByDesc('id')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('trang_thai', 'active')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $path = null;
            if ($request->hasFile('hinhanh')) {
                $image = $request->file('hinhanh');
                $path = 'uploads/products/' . time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $path);
            }
            $product = Product::create([
                'ten_san_pham' => $request->ten_san_pham,
                'mota' => $request->mota,
                'gia_coso' => $request->gia_coso,
                'id_danhmuc' => $request->id_danhmuc,
                'trang_thai' => $request->trang_thai,
                'ma_hang' => $request->ma_hang,
                'hinhanh' => $path,
            ]);
            if ($request->variants) {
                foreach ($request->variants as $variant) {
                    $product->variants()->create($variant);
                }
            }
            DB::commit();
            // return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công!');
            return redirect('/admin/products')->with('success', 'Tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Có lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with('variants', 'category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $categories = Category::where('trang_thai', 'active')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $path = $product->hinhanh;
            if ($request->hasFile('hinhanh')) {
                if ($path && file_exists(public_path($path))) {
                    unlink(public_path($path));
                }
                $image = $request->file('hinhanh');
                $path = 'uploads/products/' . time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $path);
            }
            $product->update([
                'ten_san_pham' => $request->ten_san_pham,
                'mota' => $request->mota,
                'gia_coso' => $request->gia_coso,
                'id_danhmuc' => $request->id_danhmuc,
                'trang_thai' => $request->trang_thai,
                'ma_hang' => $request->ma_hang,
                'hinhanh' => $path,
            ]);
            // Xử lý biến thể
            $product->variants()->delete();
            if ($request->variants) {
                foreach ($request->variants as $variant) {
                    $product->variants()->create($variant);
                }
            }
            DB::commit();
            return redirect('admin/products')->with('success', 'Cập nhật sản phẩm thành công!');
           
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Có lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            // Xóa orderitems và cartitems liên quan đến sản phẩm
            $product->orderItems()->delete();
            $product->cartItems()->delete();
            // Xóa orderitems và cartitems liên quan đến từng biến thể
            foreach ($product->variants as $variant) {
                $variant->orderItems()->delete();
                $variant->cartItems()->delete();
            }
            // Xóa biến thể
            $product->variants()->delete();
            // Xóa ảnh liên quan
            $product->images()->delete();
            // Xóa sản phẩm
            $product->delete();
            DB::commit();
            
            return redirect('/admin/products')->with('success', 'Đã xóa sản phẩm!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Có lỗi: ' . $e->getMessage());
        }
    }
} 