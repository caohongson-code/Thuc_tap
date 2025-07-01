@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h1>Thêm sản phẩm mới</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="ten_san_pham" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name="ten_san_pham" required>
        </div>
        <div class="mb-3">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" name="mota"></textarea>
        </div>
        <div class="mb-3">
            <label for="gia_coso" class="form-label">Giá cơ sở</label>
            <input type="number" class="form-control" name="gia_coso" required>
        </div>
        <div class="mb-3">
            <label for="id_danhmuc" class="form-label">Danh mục</label>
            <select class="form-control" name="id_danhmuc" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name ?? $cat->ten ?? 'Danh mục' }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select class="form-control" name="trang_thai">
                <option value="active">Kích hoạt</option>
                <option value="inactive">Ẩn</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="ma_hang" class="form-label">Mã hàng</label>
            <input type="text" class="form-control" name="ma_hang">
        </div>
        <div class="mb-3">
            <label for="hinhanh" class="form-label">Hình ảnh</label>
            <input type="file" class="form-control" name="hinhanh">
        </div>
        <hr>
        <h4>Biến thể sản phẩm</h4>
        <div id="variants">
            <div class="row mb-2 variant-row">
                <div class="col"><input type="text" name="variants[0][kich_co]" class="form-control" placeholder="Kích cỡ (VD: S, M, L)" required></div>
                <div class="col"><input type="number" name="variants[0][gia]" class="form-control" placeholder="Giá" required></div>
                <div class="col"><input type="number" name="variants[0][tonkho]" class="form-control" placeholder="Tồn kho" required></div>
                <div class="col-auto"><button type="button" class="btn btn-danger remove-variant">X</button></div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-variant">Thêm biến thể</button>
        <br>
        <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
    </form>
</div>
<script>
    let variantIndex = 1;
    document.getElementById('add-variant').onclick = function() {
        let html = `<div class=\"row mb-2 variant-row\">
            <div class=\"col\"><input type=\"text\" name=\"variants[${variantIndex}][kich_co]\" class=\"form-control\" placeholder=\"Kích cỡ (VD: S, M, L)\" required></div>
            <div class=\"col\"><input type=\"number\" name=\"variants[${variantIndex}][gia]\" class=\"form-control\" placeholder=\"Giá\" required></div>
            <div class=\"col\"><input type=\"number\" name=\"variants[${variantIndex}][tonkho]\" class=\"form-control\" placeholder=\"Tồn kho\" required></div>
            <div class=\"col-auto\"><button type=\"button\" class=\"btn btn-danger remove-variant\">X</button></div>
        </div>`;
        document.getElementById('variants').insertAdjacentHTML('beforeend', html);
        variantIndex++;
    };
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant')) {
            e.target.closest('.variant-row').remove();
        }
    });
</script>
@endsection 