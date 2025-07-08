<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function checkoutSubmit(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        // Lấy giỏ hàng của người dùng
        $cart = Cart::where('id_KH', $userId)->with('items')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        DB::beginTransaction();
        try {
            // Tạo đơn hàng
            $order = Order::create([
            
                'id_KH' => $userId,
                'ten' => $request->ten,
                'email' => $request->email,
                'dien_thoai' => $request->dien_thoai,
                'dia_chi' => $request->dia_chi,
                'vanchuyen_thanhpho' => $request->vanchuyen_thanhpho,
                'tong_mathang' => $cart->items->sum('so_luong'),
                'tong_gia' => $cart->tong_gia,
                'trangthai' => 'choxuly',
            ]);

            // Tạo order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'id_dathang' => $order->id,
                    'id_sanpham' => $item->id_sanpham,
                    'id_bienthe' => $item->id_bien,
                    'soluong' => $item->so_luong,
                    'gia' => $item->gia,
                    'tong_gia' => $item->tong_gia,
                ]);
            }

            // Tạo bản ghi thanh toán
            Payment::create([
                'id_donhang' => $order->id,
                'phuongthuc_thanhtoan' => $request->phuongthuc_thanhtoan,
                'trangthai_thanhtoan' => 'Chưa thanh toán',
                'sotien_thanhtoan' => $order->tong_gia,
                'ngay_thanh_toan' => now(),
            ]);

            // Xoá chi tiết giỏ hàng và giỏ hàng
            $cart->items()->delete();
            $cart->delete();

            DB::commit();
            return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
    
}
