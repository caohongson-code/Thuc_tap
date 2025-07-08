@extends('client.layouts.main')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Thanh Toán Đơn Hàng</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            {{-- Thông tin khách hàng --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Thông tin khách hàng</h4>
                    </div>


      
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ten" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" name="ten" required value="{{ old('ten', trim(($user->ho ?? '') . ' ' . ($user->ten ?? '')) ) }}">
                        </div>
                        <div class="mb-3">
                            <label for="sdt" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" name="dien_thoai" required value="{{ old('sdt', $user->dien_thoai ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required value="{{ old('email', $user->email ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="diachi" class="form-label">Địa chỉ nhận hàng</label>
                            <input type="text" class="form-control" name="dia_chi" required value="{{ old('diachi', $user->dia_chi ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="diachi" class="form-label">thành phố</label>
                            <input type="text" class="form-control" name="vanchuyen_thanhpho" required value="{{ old('vanchuyen_thanhpho', $user->thanhpho ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="ghichu" class="form-label">Ghi chú</label>
                            <textarea class="form-control" name="ghichu" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Đơn hàng --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Đơn hàng của bạn</h4>
                    </div>
                    <div class="card-body">
                        @php $tong = 0; @endphp
                        @forelse($carts as $cart)
                        
                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between align-items-start border-bottom py-2">
                                    <div>
                                        <strong>{{ $item->variant->product->ten_san_pham ?? '' }}</strong>
                                        <img src="{{ asset($item->variant->product->hinhanh ?? '') }}" width="50px"><br>
                                        <small>Kích cỡ: {{ $item->variant->kich_co ?? '' }}</small>
                                    </div>
                                    <div class="text-end">
                                        x{{ $item->so_luong }}<br>
                                        {{ number_format($item->tong_gia,0,',','.') }}đ
                                    </div>
                                </div>
                                @php $tong += $item->tong_gia; @endphp
                            @endforeach
                        @empty
                            <p>Không có sản phẩm trong giỏ hàng.</p>
                        @endforelse

                        <div class="d-flex justify-content-between mt-3 border-top pt-3">
                            <h5 class="mb-0">Tổng cộng:</h5>
                            <h5 class="mb-0 text-danger">{{ number_format($tong,0,',','.') }}đ</h5>
                        </div>
                    </div>
                </div>
<div class="mb-3">
    <label class="form-label">Phương thức thanh toán</label>
    <select name="phuongthuc_thanhtoan" class="form-select">
        <option value="COD">Thanh toán khi nhận hàng</option>
        <option value="BANK">Chuyển khoản ngân hàng</option>
    </select>
</div>

                <button type="submit" class="btn btn-lg btn-success mt-4 w-100 shadow">Đặt hàng</button>
            </div>
        </div>
    </form>
</div>
@endsection
