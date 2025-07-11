@extends('client.layouts.main')
@section('title', 'Lịch sử đơn hàng')
@section('content')

<div class="container py-5">
    <h2 class="mb-4 text-success"><i class="fas fa-history me-2"></i>Lịch sử đơn hàng</h2>

    {{-- Thông báo --}}
    @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
        @if(session($key))
            <div class="alert alert-{{ $type }} text-center">
                {{ session($key) }}
            </div>
        @endif
    @endforeach

    @if($orders->isEmpty())
        <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng mặt hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order['id'] }}</td>
                        <td>{{ $order['ngay_capnhat'] }}</td>
                        <td>{{ $order['tong_mathang'] }}</td>
                        <td>{{ number_format($order['tong_gia']) }}đ</td>
                       
  <td>
    @php
        $trangthaiLabels = [
            'choxuly' => 'Chờ xử lí',
            'daxacnhan' => 'Đã xác nhận',
            'davanchuyen' => 'Đã vận chuyển',
            'danggiao' => 'Đang giao hàng',
            'thanhcong' => 'Giao hàng thành công',
            'danhanhang' => 'Đã nhận hàng',
            'hoan_thanh' => 'Hoàn thành',
            'huy' => 'Huỷ thành công',
        ];

        $status = $order['trangthai'];
        $label = $trangthaiLabels[$status] ?? ucfirst($status);
        $class = match($status) {
            'choxuly' => 'warning',
            'daxacnhan' => 'info',
            'davanchuyen', 'primary',
            'daggiao', 'dangiao' => 'primary',
            'thanhcong', 'hoan_thanh' => 'success',
            'danhanhang' => 'primary',
            'huy' => 'danger',
            default => 'secondary',
        };
    @endphp

    <span class="badge bg-{{ $class }}">{{ $label }}</span>
</td>
<td>
    <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#order-{{ $order['id'] }}">
        <i class="fas fa-eye"></i> Xem
    </button>

    @if(in_array($order['trangthai'], ['choxuly', 'daxacnhan', 'davanchuyen']))
        <form method="POST" action="{{ route('orders.cancel', $order['id']) }}" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn huỷ đơn hàng này?')">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-times-circle"></i> Huỷ đơn
            </button>
        </form>
    @endif
    @if($order['trangthai'] == 'thanhcong')
        <form method="POST" action="{{ route('orders.confirmReceived', $order['id']) }}" class="d-inline" onsubmit="return confirm('Bạn chắc chắn đã nhận được hàng?')">
            @csrf
            <button type="submit" class="btn btn-sm btn-success">
                Tôi đã nhận hàng
            </button>
        </form>
    @elseif($order['trangthai'] == 'danhanhang')
        <span class="badge bg-primary">Đã nhận hàng</span>
    @endif
</td>

                    </tr>

                    {{-- Chi tiết --}}
{{-- Chi tiết đơn hàng --}}
<tr class="collapse bg-light" id="order-{{ $order['id'] }}">
    <td colspan="6">
        <div class="row">
            {{-- Thông tin nhận hàng --}}
            <div class="col-md-5 border-end">
                <h6 class="fw-bold mb-3">Thông tin nhận hàng</h6>
                <ul class="list-unstyled small">
                    <li><strong>Họ tên:</strong> {{ $order['ten'] ?? '' }}</li>
                    <li><strong>Điện thoại:</strong> {{ $order['dien_thoai'] }}</li>
                    <li><strong>Email:</strong> {{ $order['email'] }}</li>
                    <li><strong>Địa chỉ:</strong> {{ $order['dia_chi'] }}</li>
                    <li><strong>Ghi chú:</strong> {{ $order['ghi_chu'] ?? '(Không có)' }}</li>
                </ul>
            </div>

            {{-- Chi tiết sản phẩm --}}
            <div class="col-md-7">
                <h6 class="fw-bold mb-3">Chi tiết sản phẩm</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th>Kích cỡ</th>
                                <th>SL</th>
                                <th>Giá</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order['items'] as $item)
                            <tr>
                                <td>
                                    @if(!empty($item['hinh_sanpham']))
                                        <img src="{{ asset('/' . $item['hinh_sanpham']) }}" width="50" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $item['ten_sanpham'] }}</td>
                                <td>{{ $item['kich_co'] }}cm</td>
                                <td>{{ $item['soluong'] }}</td>
                                <td>{{ number_format($item['gia']) }}đ</td>
                                <td>{{ number_format($item['tong_gia']) }}đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </td>
</tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection
