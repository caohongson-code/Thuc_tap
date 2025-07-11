@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Quản lý đơn hàng</h2>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Tổng giá</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->ten }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->dien_thoai }}</td>
                <td>{{ $order->dia_chi }}</td>
                <td>{{ number_format($order->tong_gia, 0, ',', '.') }}₫</td>
                <td>
                    @if($order->trangthai == 'choxuly')
                        <span class="badge bg-warning">Chờ xử lý</span>
                    @elseif($order->trangthai == 'daxacnhan')
                        <span class="badge bg-success">Đã xác nhận</span>
                    @elseif($order->trangthai == 'davanchuyen')
                        <span class="badge bg-info">Đang vận chuyển</span>
                    @elseif($order->trangthai == 'danggiao')
                        <span class="badge bg-primary">Đang giao</span>
                    @elseif($order->trangthai == 'thanhcong')
                        <span class="badge bg-success">Thành công</span>
                    @elseif($order->trangthai == 'danhanhang')
                        <span class="badge bg-secondary">Đã nhận hàng</span>
                    @elseif($order->trangthai == 'huy')
                        <span class="badge bg-danger">Đã hủy</span>
                    @endif
                </td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection 