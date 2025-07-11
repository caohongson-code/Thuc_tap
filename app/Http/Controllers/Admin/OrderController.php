<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');
        if ($request->filled('q')) {
            $query->where('ten', 'like', '%' . $request->q . '%');
        }
        $orders = $query->paginate(20)->appends(['q' => $request->q]);
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
            'danhanhang' => 'Đã nhận hàng',
            'huy' => 'Huỷ'
        ];
        $nextStatus = [
            'choxuly' => ['daxacnhan', 'huy'],
            'daxacnhan' => ['davanchuyen', 'huy'],
            'davanchuyen' => ['danggiao'],
            'danggiao' => ['thanhcong'],
            'thanhcong' => [], // admin không chuyển được nữa, chỉ khách mới chuyển sang 'danhanhang'
            'danhanhang' => [],
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
            'thanhcong' => [], // admin không chuyển được nữa, chỉ khách mới chuyển sang 'danhanhang'
            'danhanhang' => [],
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