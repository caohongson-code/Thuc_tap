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
                    <span class="badge bg-info">{{ $order->trangthai }}</span>
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