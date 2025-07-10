@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <p><strong>Khách hàng:</strong> {{ $order->ten }} ({{ $order->email }})</p>
    <p><strong>Điện thoại:</strong> {{ $order->dien_thoai }}</p>
    <p><strong>Địa chỉ:</strong> {{ $order->dia_chi }}</p>
    <p><strong>Trạng thái:</strong> <span class="badge bg-info">{{ $statusLabels[$order->trangthai] ?? $order->trangthai }}</span></p>
    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mb-3">
        @csrf
        @method('PATCH')
        <div class="input-group" style="max-width: 300px;">
            <select name="trangthai" class="form-select">
                @foreach($allowed as $status)
                    <option value="{{ $status }}" {{ $order->trangthai == $status ? 'selected' : '' }}>
                        {{ $statusLabels[$status] ?? $status }}
                    </option>
                @endforeach
            </select>
            <button class="btn btn-success" type="submit">Cập nhật</button>
        </div>
    </form>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <h4>Sản phẩm</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Kích cỡ</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->ten_san_pham ?? ($item->variant->product->ten_san_pham ?? '') }}</td>
                <td>{{ $item->variant->kich_co ?? '' }}</td>
                <td>{{ $item->soluong }}</td>
                <td>{{ number_format($item->gia, 0, ',', '.') }}₫</td>
                <td>{{ number_format($item->tong_gia, 0, ',', '.') }}₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->tong_gia, 0, ',', '.') }}₫</p>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection 