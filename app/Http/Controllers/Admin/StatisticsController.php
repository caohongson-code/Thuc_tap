<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
          $totalOrders = Order::count();
    $totalRevenue = Order::where('trangthai', 'thanhcong')->sum('tong_gia');
        $type = $request->get('type', 'week');
        $labels = [];
        $dataRange = [];
        $statusList = ['choxuly', 'daxacnhan', 'davanchuyen', 'danggiao', 'thanhcong', 'huy'];
        $statusLabels = [
            'choxuly' => 'Chờ xử lý',
            'daxacnhan' => 'Đã xác nhận',
            'davanchuyen' => 'Đã vận chuyển',
            'danggiao' => 'Đang giao hàng',
            'thanhcong' => 'Giao hàng thành công',
            'huy' => 'Huỷ'
        ];

        if ($type === 'year') {
            $dataRange = range(1, 12);
            foreach ($dataRange as $i) {
                $labels[] = 'Tháng ' . $i;
            }

            $orders = Order::whereYear('created_at', now()->year)
                ->selectRaw('MONTH(created_at) as time, trangthai, COUNT(*) as total')
                ->groupBy('time', 'trangthai')
                ->orderBy('time')
                ->get();
        } elseif ($type === 'month') {
            $days = now()->daysInMonth;
            $dataRange = range(1, $days);
            foreach ($dataRange as $i) {
                $labels[] = 'Ngày ' . $i;
            }

            $orders = Order::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->selectRaw('DAY(created_at) as time, trangthai, COUNT(*) as total')
                ->groupBy('time', 'trangthai')
                ->orderBy('time')
                ->get();
        } else {
            $startOfWeek = now()->startOfWeek(); // Monday
            for ($i = 0; $i < 7; $i++) {
                $date = $startOfWeek->copy()->addDays($i);
                $dataRange[] = $date->toDateString();
                $labels[] = $date->translatedFormat('l'); // Thứ Hai, Thứ Ba, ...
            }

            $orders = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->selectRaw('DATE(created_at) as time, trangthai, COUNT(*) as total')
                ->groupBy('time', 'trangthai')
                ->orderBy('time')
                ->get();
        }

        // Khởi tạo datasets với tất cả giá trị bằng 0
        $datasets = [];
        foreach ($statusList as $status) {
            $datasets[$status] = array_fill(0, count($dataRange), 0);
        }

        // Gán dữ liệu vào đúng vị trí
        foreach ($orders as $row) {
            $timeKey = $type === 'week' ? $row->time : (int)$row->time;
            $index = array_search($timeKey, $dataRange);
            if ($index !== false && isset($datasets[$row->trangthai])) {
                $datasets[$row->trangthai][$index] = $row->total;
            }
        }

        return view('admin.thongke.index', [
            'type' => $type,
            'labels' => $labels,
            'datasets' => $datasets,
            'statusLabels' => $statusLabels,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue
        ]);
    }
}
