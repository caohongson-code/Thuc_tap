<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function history()
    {
        $userId = Auth::id();
        $orders = Order::where('id_KH', $userId)
            ->with(['items.variant.product'])
            ->orderByDesc('created_at')
            ->get();

        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'tong_mathang' => $order->tong_mathang,
                'tong_gia' => $order->tong_gia,
                'trangthai' => $order->trangthai,
                'email' => $order->email,
                'dien_thoai' => $order->dien_thoai,
                'dia_chi' => $order->dia_chi,
                'ghi_chu' => $order->ghichu,
                'ten' => $order->ten,
                'ngay_capnhat' => $order->updated_at->format('d/m/Y H:i'),
                'items' => $order->items->map(function ($item) {
                    return [
                        'id_sanpham' => $item->id_sanpham,
                        'ten_sanpham' => $item->variant->product->ten_san_pham ?? '',
                        'kich_co' => $item->variant->kich_co ?? '',
                        'hinh_sanpham' => $item->variant->product->hinhanh ?? null,
                        'soluong' => $item->soluong,
                        'gia' => $item->gia,
                        'tong_gia' => $item->tong_gia,
                    ];
                })
            ];
        });

        $banners = Banner::all();
        return view('client.lichsu', ['orders' => $data, 'banners' => $banners]);
    }

    public function cancel($id)
    {
        $order = Order::where('id', $id)->where('id_KH', Auth::id())->firstOrFail();

  if (!in_array($order->trangthai, ['choxuly', 'daxacnhan', 'davanchuyen'])) {
    return back()->with('error', 'Không thể huỷ đơn hàng ở trạng thái hiện tại!');
}

$order->trangthai = 'huy';

$order->save();
        return back()->with('success', 'Đơn hàng đã được huỷ.');
    }

    public function confirmReceived($id)
    {
        $order = \App\Models\Order::where('id', $id)
            ->where('id_KH', \Auth::id())
            ->where('trangthai', 'da_giao_hang')
            ->firstOrFail();

        $order->trangthai = 'hoan_thanh';
        $order->save();

        return back()->with('success', 'Cảm ơn bạn đã xác nhận đã nhận hàng!');
    }
}



