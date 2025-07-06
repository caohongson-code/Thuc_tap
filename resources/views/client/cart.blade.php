@extends('client.layouts.main')
@section('content')

@php
    use Illuminate\Support\Collection;

    // Gom nhóm các mục giống nhau: cùng sản phẩm & biến thể
    $groupedItems = $carts->flatMap->items
        ->groupBy(fn($item) => $item->id_sanpham . '_' . $item->id_bien);
@endphp

<div class="container py-5">
    <h2 class="mb-4 text-success">🛒 Giỏ hàng của bạn</h2>
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-success">
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Kích cỡ</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @php $tongTien = 0; @endphp

 @foreach($groupedItems as $group)
    @php
        $first = $group->first();
        $product = $first->variant->product ?? null;
        $soLuong = $group->sum('so_luong'); // ✅ Sửa tại đây
        $tong = $group->sum('tong_gia');
        $tongTien += $tong;
    @endphp

    <tr>
        <td>
            @if($product && $product->hinhanh)
                <img src="{{ asset($product->hinhanh) }}" width="70">
            @endif
        </td>
        <td>{{ $product->ten_san_pham ?? 'N/A' }}</td>
        <td>{{ $first->variant->kich_co ?? 'N/A' }} cm</td>
        <td>{{ number_format($first->gia, 0, ',', '.') }}₫</td>
        <td>{{ $soLuong }}</td>
        <td>{{ number_format($tong, 0, ',', '.') }}₫</td>
    </tr>
@endforeach

            </tbody>
        </table>
    </div>

    <div class="row justify-content-end">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Tổng cộng: <span class="text-success">{{ number_format($tongTien, 0, ',', '.') }}₫</span></h5>
                <a href="{{ route('checkout.form') }}" class="btn btn-success w-100">Tiến hành thanh toán</a>
            </div>
        </div>
    </div>
</div>

@endsection

