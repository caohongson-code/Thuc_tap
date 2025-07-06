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
        // Validation
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'gia_coso' => 'required|numeric|min:0',
            'id_danhmuc' => 'required|exists:categories,id',
            'trang_thai' => 'required|in:active,inactive',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.kich_co' => 'required|numeric|min:0',
            'variants.*.gia' => 'required|numeric|min:0',
            'variants.*.tonkho' => 'required|integer|min:0',
        ]);
        
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
            if ($request->variants && is_array($request->variants)) {
                foreach ($request->variants as $variant) {
                    if (!empty($variant['kich_co']) && !empty($variant['gia']) && !empty($variant['tonkho'])) {
                        $product->variants()->create([
                            'kich_co' => $variant['kich_co'],
                            'gia' => $variant['gia'],
                            'tonkho' => $variant['tonkho']
                        ]);
                    }
                }
            }
            DB::commit();
            // return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công!');
            return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công!');
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
        // Validation
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'gia_coso' => 'required|numeric|min:0',
            'id_danhmuc' => 'required|exists:categories,id',
            'trang_thai' => 'required|in:active,inactive',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.kich_co' => 'required|numeric|min:0',
            'variants.*.gia' => 'required|numeric|min:0',
            'variants.*.tonkho' => 'required|integer|min:0',
        ]);
        
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
            // Xử lý biến thể - cập nhật thay vì xóa và tạo lại
            $existingVariants = $product->variants;
            $updatedVariantIds = [];
            
            if ($request->variants && is_array($request->variants)) {
                foreach ($request->variants as $index => $variant) {
                    if (!empty($variant['kich_co']) && !empty($variant['gia']) && !empty($variant['tonkho'])) {
                        // Nếu có variant hiện tại với index này, cập nhật nó
                        if (isset($existingVariants[$index])) {
                            $existingVariants[$index]->update([
                                'kich_co' => $variant['kich_co'],
                                'gia' => $variant['gia'],
                                'tonkho' => $variant['tonkho']
                            ]);
                            $updatedVariantIds[] = $existingVariants[$index]->id;
                        } else {
                            // Tạo variant mới
                            $newVariant = $product->variants()->create([
                                'kich_co' => $variant['kich_co'],
                                'gia' => $variant['gia'],
                                'tonkho' => $variant['tonkho']
                            ]);
                            $updatedVariantIds[] = $newVariant->id;
                        }
                    }
                }
            }
            
            // Xóa các variants không còn được sử dụng (chỉ xóa những variant không có trong cartitems)
            $cannotDeleteVariants = [];
            foreach ($existingVariants as $existingVariant) {
                if (!in_array($existingVariant->id, $updatedVariantIds)) {
                    // Kiểm tra xem variant có được sử dụng trong cartitems không
                    $hasCartItems = $existingVariant->cartItems()->exists();
                    if (!$hasCartItems) {
                        $existingVariant->delete();
                    } else {
                        $cannotDeleteVariants[] = $existingVariant->kich_co;
                    }
                }
            }
            DB::commit();
            
            $message = 'Cập nhật sản phẩm thành công!';
            if (!empty($cannotDeleteVariants)) {
                $message .= ' Lưu ý: Một số biến thể (kích cỡ: ' . implode(', ', $cannotDeleteVariants) . ') không thể xóa vì đang được sử dụng trong giỏ hàng.';
            }
            
            return redirect()->route('admin.products.index')->with('success', $message);
           
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
            
            return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Có lỗi: ' . $e->getMessage());
        }
    }
} 