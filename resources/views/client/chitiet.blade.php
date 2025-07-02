@extends('Client.layouts.main')
@section('content')

<div class="container py-4">
    <div class="row bg-white p-4 rounded shadow-sm">
        <div class="col-md-5 d-flex justify-content-center align-items-center">
            @if($product->hinhanh)
                <img src="{{ asset('/' . $product->hinhanh) }}" 
                     class="img-fluid rounded border" 
                     style="max-height: 350px; object-fit: contain;">
            @endif
        </div>

        <div class="col-md-7">
            <h3 class="fw-bold mb-3 text-danger">{{ $product->ten_san_pham }}</h3>
            <p class="mb-2"><strong>Danh mục:</strong> {{ $product->category->ten ?? 'Không rõ' }}</p>

            {{-- Trạng thái: Nếu có ít nhất 1 biến thể tồn kho > 0 --}}
            @php
                $conHang = $product->variants->sum('tonkho') > 0;
            @endphp
            <p class="mb-2">
                <strong>Trạng thái:</strong>
                <span class="badge {{ $conHang ? 'bg-success' : 'bg-danger' }}" style="color: white">
                    {{ $conHang ? 'Còn hàng' : 'Hết hàng' }}
                </span>
            </p>

<form>
    {{-- Chọn kích cỡ --}}
    <div class="mb-3">
        <label for="variantSelect"><strong>Kích cỡ:</strong></label>
        <select class="form-select" id="variantSelect" required>
            <option value="" disabled selected>-- Chọn kích cỡ --</option>
            @foreach($product->variants as $variant)
                <option value="{{ $variant->id }}"
                        data-price="{{ $variant->gia }}"
                        data-stock="{{ $variant->tonkho }}">
                    {{ $variant->kich_co }} ({{ number_format($variant->gia, 0, ',', '.') }}₫)
                </option>
            @endforeach
        </select>
    </div>

    {{-- Hiển thị tồn kho khi chọn kích cỡ --}}
    <div class="mb-3" id="stockInfo" style="display: none;">
        <span class="text-muted">Tồn kho: <span id="stockValue" class="fw-bold text-success">0</span></span>
    </div>

    {{-- Nhập số lượng --}}
    <div class="mb-3">
        <label for="quantity"><strong>Số lượng:</strong></label>
        <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="1" disabled >
    </div>

    <button type="submit" class="btn btn-danger">Thêm vào giỏ</button>
</form>

        </div>
    </div>
    <h1>mô tả</h1>
    <div class="mt-4">
        <p>{{ $product->mota }}</p>
</div>
<div class="container mt-5">
    <h4 class="mb-4 text-success">Sản phẩm tương tự</h4>
    <div class="row">
        @foreach($relatedProducts as $item)
            <div class="col-md-3">
                <div class="card mb-3">
                    <a href="{{ route('client.show', $item->id) }}">
                        <img src="{{ asset('/' . $item->hinhanh) }}" class="card-img-top" alt="{{ $item->ten_san_pham }}">
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $item->ten_san_pham }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($item->gia_coso, 0, ',', '.') }}₫</p>
                        <a href="{{ route('client.show', $item->id) }}" class="btn btn-sm btn-outline-success">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    const select = document.getElementById('variantSelect');
    const qtyInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stockInfo');
    const stockValue = document.getElementById('stockValue');

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const stock = selected.getAttribute('data-stock');

        if (stock) {
            // Gán tồn kho ra view
            stockValue.textContent = stock;
            stockInfo.style.display = 'block';

            // Cập nhật input
            qtyInput.disabled = false;
            qtyInput.max = stock;
            qtyInput.value = 1;
        }
    });

    qtyInput.addEventListener('input', function () {
        const max = parseInt(this.max);
        let val = parseInt(this.value);

        if (val > max) this.value = max;
        if (val < 1 || isNaN(val)) this.value = 1;
    });
</script>


@endsection
