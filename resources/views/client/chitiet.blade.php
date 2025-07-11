@extends('client.layouts.main')
@section('content')
<br>
@foreach (['error' => 'danger', 'success' => 'success'] as $key => $type)
    @if (session($key))
        <div class="alert alert-{{ $type }} alert-dismissible fade show position-relative border rounded shadow-sm px-4 py-2 mx-auto text-center"
             style="width: fit-content; min-width: 200px;" role="alert">
            {{ session($key) }}
       <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
        data-bs-dismiss="alert" aria-label="Close"></button>


        </div>
    @endif
@endforeach



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

<form id="addToCartForm" action="{{ route('cart.add') }}" method="POST" enctype="multipart/form-data">
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
@if (Auth::check())
<form action="{{ route('comments.store') }}" method="POST" class="mb-3">
    @csrf
    <input type="hidden" name="id_sanpham" value="{{ $product->id }}">
    
    <div class="mb-2">
        <textarea name="noi_dung" class="form-control form-control-sm" rows="2" placeholder="Viết bình luận..." required></textarea>
    </div>
    
    <button type="submit" class="btn btn-sm btn-success">Gửi bình luận</button>
</form>

@endif
@foreach($product->comments as $comment)
    <div class="card mb-3 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-start flex-wrap">
            <div class="me-3" style="flex: 1;">
                <h6 class="mb-1 text-primary">
                    <i class="fas fa-user me-1"></i>
                    {{ $comment->user->ho }} {{ $comment->user->ten }}
                    <small class="text-muted d-block">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                </h6>
                <p class="mb-0">{{ $comment->noi_dung }}</p>
            </div>

            @if(auth()->id() === $comment->id_KH)
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xoá bình luận?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger mt-1">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
@endforeach



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
<script>
    // ... (các đoạn đã có ở trên)

    document.getElementById('addToCartForm').addEventListener('submit', function (e) {
        const variantSelected = select.value;

        if (!variantSelected) {
            e.preventDefault(); // chặn gửi form
            alert('Vui lòng chọn kích cỡ trước khi thêm vào giỏ hàng!');
            select.focus();
        }
    });
</script>

@if(session('showLoginModal'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });
    </script>
@endif
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-success shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success w-100">Đăng nhập</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
