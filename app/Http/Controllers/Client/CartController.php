<?php
namespace App\Http\Controllers\Client;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;

class CartController extends Controller
{
public function addToCart(Request $request)
{
        if (!Auth::check()) {
        // Nếu chưa đăng nhập → trả về HTML modal qua redirect (flash)
        return back()->with('showLoginModal', true);
    }
    $userId = Auth::id();
    $productId = $request->input('id_san_pham');
    $variantId = $request->input('variant_id');
    $quantity = (int)$request->input('quantity');

    $variant = ProductVariant::where('id', $variantId)
        ->where('id_sanpham', $productId)
        ->first();

    if (!$variant) {
        return back()->with('error', 'Không tìm thấy biến thể sản phẩm');
    }

    // Tìm hoặc tạo giỏ hàng cho user
    $cart = Cart::firstOrCreate(
        ['id_KH' => $userId],
        ['id_sanpham' => $productId, 'tong_mathang' => 0, 'tong_gia' => 0]
    );

    // Kiểm tra xem đã có item này trong giỏ chưa
    $existingItem = CartItem::where('id_giohang', $cart->id)
        ->where('id_sanpham', $productId)
        ->where('id_bien', $variantId)
        ->first();

    // Tổng số lượng đã có trong giỏ + đang thêm
    $soLuongHienTai = $existingItem ? $existingItem->so_luong : 0;
    $tongSoLuong = $soLuongHienTai + $quantity;

    if ($tongSoLuong > $variant->tonkho) {
        return back()->with('error', 'Không đủ hàng tồn kho. Bạn đã có ' . $soLuongHienTai . ' sản phẩm này trong giỏ.');
    }

    $price = $variant->gia;
    $totalPrice = $price * $quantity;

    if ($existingItem) {
        $existingItem->so_luong += $quantity;
        $existingItem->tong_gia += $totalPrice;
        $existingItem->save();
    } else {
        CartItem::create([
            'id_giohang' => $cart->id,
            'id_sanpham' => $productId,
            'id_bien' => $variantId,
            'gia' => $price,
            'so_luong' => $quantity,
            'tong_gia' => $totalPrice,
        ]);
    }

    // Cập nhật giỏ hàng tổng
    $cart->tong_mathang += $quantity;
    $cart->tong_gia += $totalPrice;
    $cart->save();

    return redirect()->route('client.show', $productId)->with('success', 'Đã thêm vào giỏ hàng');

}


public function show()
{
    $userId = Auth::id();

    // Lấy giỏ hàng và load quan hệ sâu: items.variant.product
    $carts = Cart::where('id_KH', $userId)
        ->with('items.variant.product')  // << CHỖ QUAN TRỌNG
        ->get();
    $banners = Banner::all();

    return view('client.cart', compact('carts', 'banners'));
}

}
