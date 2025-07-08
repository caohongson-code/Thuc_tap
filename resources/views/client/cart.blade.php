@extends('client.layouts.main')
@section('content')

@php
    use Illuminate\Support\Collection;

    $groupedItems = $carts->flatMap->items
        ->groupBy(fn($item) => $item->id_sanpham . '_' . $item->id_bien);
@endphp

<div class="container py-5">
    <h2 class="mb-4 text-success">🛒 Giỏ hàng của bạn</h2>

    {{-- Thông báo flash --}}
    @foreach (['success' => 'success', 'error' => 'danger'] as $key => $type)
        @if(session($key))
            <div class="alert alert-{{ $type }} text-center">
                {{ session($key) }}
            </div>
        @endif
    @endforeach

    {{-- Nếu giỏ hàng trống --}}
    @if($groupedItems->isEmpty())
        <div class="alert alert-info text-center">
            🧺 Giỏ hàng của bạn đang trống.
        </div>
    @else
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
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php $tongTien = 0; @endphp

                    @foreach($groupedItems as $group)
                        @php
                            $first = $group->first();
                            $product = $first->variant->product ?? null;
                            $soLuong = $group->sum('so_luong');
                            $tong = $group->sum('tong_gia');
                            $tongTien += $tong;
                        @endphp

                        <tr>
                            <td>
                                @if($product && $product->hinhanh)
                                    <img src="{{ asset($product->hinhanh) }}" width="70">
                                @else
                                    <em>Không ảnh</em>
                                @endif
                            </td>
                            <td>{{ $product->ten_san_pham ?? 'N/A' }}</td>
                            <td>{{ $first->variant->kich_co ?? 'N/A' }} cm</td>
                            <td>{{ number_format($first->gia, 0, ',', '.') }}₫</td>
                            <td>
                                <form action="{{ route('cart.update', [$first->id_sanpham, $first->id_bien]) }}" method="POST" class="d-flex justify-content-center align-items-center gap-1">
                                    @csrf
                                    <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary">-</button>
                                    <span class="px-2">{{ $soLuong }}</span>
                                    <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-secondary">+</button>
                                </form>
                            </td>
                            <td>{{ number_format($tong, 0, ',', '.') }}₫</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $first->id) }}" onsubmit="return confirm('Bạn có chắc muốn xoá sản phẩm này?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </td>
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
    @endif
</div>

@endsection
