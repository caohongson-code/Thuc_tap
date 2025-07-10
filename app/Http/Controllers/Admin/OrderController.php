<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        $statusLabels = [
            'choxuly' => 'Chờ xử lý',
            'daxacnhan' => 'Đã xác nhận',
            'davanchuyen' => 'Đã vận chuyển',
            'danggiao' => 'Đang giao hàng',
            'thanhcong' => 'Giao hàng thành công',
            'huy' => 'Huỷ'
        ];
        $nextStatus = [
            'choxuly' => ['daxacnhan', 'huy'],
            'daxacnhan' => ['davanchuyen', 'huy'],
            'davanchuyen' => ['danggiao', 'huy'],
            'danggiao' => ['thanhcong', 'huy'],
            'thanhcong' => [],
            'huy' => [],
        ];
        $current = $order->trangthai;
        $allowed = array_merge([$current], $nextStatus[$current] ?? []);
        return view('admin.orders.show', compact('order', 'allowed', 'statusLabels'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'trangthai' => 'required|string',
        ]);

        $nextStatus = [
            'choxuly' => ['daxacnhan', 'huy'],
            'daxacnhan' => ['davanchuyen', 'huy'],
            'davanchuyen' => ['danggiao', 'huy'],
            'danggiao' => ['thanhcong', 'huy'],
            'thanhcong' => [],
            'huy' => [],
        ];
        $current = $order->trangthai;
        $allowed = array_merge([$current], $nextStatus[$current] ?? []);
        if (!in_array($request->trangthai, $allowed)) {
            return back()->with('error', 'Không thể chuyển trạng thái này!');
        }
        $order->trangthai = $request->trangthai;
        $order->save();
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Cập nhật trạng thái thành công!');
    }
} 