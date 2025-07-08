<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
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

        $cart = Cart::firstOrCreate(
            ['id_KH' => $userId],
            ['id_sanpham' => $productId, 'tong_mathang' => 0, 'tong_gia' => 0]
        );

        $existingItem = CartItem::where('id_giohang', $cart->id)
            ->where('id_sanpham', $productId)
            ->where('id_bien', $variantId)
            ->first();

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

        $cart->tong_mathang += $quantity;
        $cart->tong_gia += $totalPrice;
        $cart->save();

        return redirect()->route('client.show', $productId)->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function show()
    {
            $userId = Auth::id();

    $carts = \App\Models\Cart::where('id_KH', $userId)
                ->with(['items.variant.product'])
                ->get();
        $userId = Auth::id();
        $carts = Cart::where('id_KH', $userId)->with('items.variant.product')->get();
        $banners = Banner::all();

        return view('client.cart', compact('carts', 'banners','carts'));
    }

    public function checkoutForm(Request $request)
    {
        $userId = Auth::id();
        $carts = Cart::where('id_KH', $userId)->with('items.variant.product')->get();
        $banners = Banner::all();
        $user = Auth::user();
        return view('client.checkout', compact('carts', 'banners', 'user'));
    }

    public function checkoutSubmit(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'ten' => 'required|string|max:255',
            'sdt' => 'required|string|max:20',
            'diachi' => 'required|string|max:255',
            'ghichu' => 'nullable|string|max:500',
        ]);

        $carts = Cart::where('id_KH', $userId)->with('items')->get();
        if ($carts->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'id_KH' => $userId,
                'id_giohang' => $carts->first()->id,
                'ten' => $request->ten,
                'sdt' => $request->sdt,
                'diachi' => $request->diachi,
                'ghichu' => $request->ghichu,
                'tong_gia' => $carts->sum('tong_gia'),
                'trang_thai' => 'pending',
            ]);

            foreach ($carts as $cart) {
                foreach ($cart->items as $item) {
                    OrderItem::create([
                        'id_donhang' => $order->id,
                        'id_sanpham' => $item->id_sanpham,
                        'id_bien' => $item->id_bien,
                        'so_luong' => $item->so_luong,
                        'gia' => $item->gia,
                        'tong_gia' => $item->tong_gia,
                    ]);
                }
            }

            Payment::create([
                'id_donhang' => $order->id,
                'phuongthuc_thanhtoan' => 'COD',
                'trangthai_thanhtoan' => 'Chưa thanh toán',
                'sotien_thanhtoan' => $order->tong_gia,
                'ngay_thanh_toan' => now(),
            ]);

            foreach ($carts as $cart) {
                $cart->items()->delete();
                $cart->delete();
            }

            DB::commit();
            return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    public function updateQuantity($id_sanpham, $id_bien, Request $request)
{
    $cart = Cart::where('id_KH', Auth::id())->firstOrFail();

    $item = $cart->items()
        ->where('id_sanpham', $id_sanpham)
        ->where('id_bien', $id_bien)
        ->first();

    if (!$item) {
        return back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
    }

    if ($request->action === 'increase') {
        $item->so_luong += 1;
    } elseif ($request->action === 'decrease' && $item->so_luong > 1) {
        $item->so_luong -= 1;
    }

    $item->tong_gia = $item->so_luong * $item->gia;
    $item->save();

    // Cập nhật tổng giá của giỏ hàng
    $cart->tong_gia = $cart->items()->sum('tong_gia');
    $cart->save();

    return back()->with('success', 'Cập nhật số lượng thành công.');
}
public function removeItem($itemId)
{
    $item = \App\Models\CartItem::findOrFail($itemId);
    $cart = $item->cart;

    $item->delete();

    // Cập nhật lại tổng giá giỏ hàng
    $cart->tong_gia = $cart->items()->sum('tong_gia');
    $cart->save();

    return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng.');
}


}