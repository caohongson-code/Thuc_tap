@extends('client.layouts.main')
@section('content')
<br>
@foreach (['error' => 'danger', 'success' => 'success'] as $key => $type)
    @if (session($key))
        <div class="alert alert-{{ $type }} alert-dismissible fade show position-relative border rounded shadow-sm px-4 py-2 mx-auto" 
             style="max-width: 500px;" role="alert">
            {{ session($key) }}
            <button type="button" class="btn-close position-absolute top-0 end-0 m-2" 
                    data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>
    @endif
@endforeach





@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
@endif

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

                <form action="{{ route('cart.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <input type="hidden" name="id_san_pham" value="{{ $product->id }}">
                    <input type="hidden" id="variant_id" name="variant_id" value="">
                    <div class="mb-3">
                        <label for="variantSelect"><strong>Kích cỡ:</strong></label>
                        <select class="form-select" id="variantSelect" required>
                            <option value="" disabled selected>-- Chọn kích cỡ --</option>
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}"
                                        data-stock="{{ $variant->tonkho }}"
                                        data-price="{{ $variant->gia }}">
                                    {{ $variant->kich_co }} cm
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" id="stockInfo" style="display: none;">
                        <span class="text-muted">Tồn kho: <span id="stockValue" class="fw-bold text-success">0</span></span>
                    </div>
                <div class="mb-3" id="priceInfo" style="display: none;">
                    <span class="text-muted">Giá: <span id="priceValue" class="fw-bold text-success">0₫</span></span>
                </div>

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
    const variantIdInput = document.getElementById('variant_id');

    const priceInfo = document.getElementById('priceInfo');
    const priceValue = document.getElementById('priceValue');

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const stock = selected.getAttribute('data-stock');
        const price = selected.getAttribute('data-price');
        const variantId = selected.value;

        // Hiển thị tồn kho
        if (stock) {
            stockValue.textContent = stock;
            stockInfo.style.display = 'block';
            qtyInput.disabled = false;
            qtyInput.max = stock;
            qtyInput.value = 1;
            variantIdInput.value = variantId;
        }

        // Hiển thị giá
        if (price) {
            const priceFormatted = new Intl.NumberFormat('vi-VN').format(price) + '₫';
            priceValue.textContent = priceFormatted;
            priceInfo.style.display = 'block';
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
