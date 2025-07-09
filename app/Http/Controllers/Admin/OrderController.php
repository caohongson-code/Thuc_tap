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
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'trangthai' => 'required|string',
        ]);

        $nextStatus = [
            'cho_xac_nhan' => ['da_xac_nhan', 'da_huy'],
            'da_xac_nhan' => ['chuan_bi_hang', 'da_huy'],
            'chuan_bi_hang' => ['dang_giao_hang', 'da_huy'],
            'dang_giao_hang' => ['da_giao_hang', 'da_huy'],
            'da_giao_hang' => ['tra_hang', 'da_huy'],
            'tra_hang' => [],
            'da_huy' => [],
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