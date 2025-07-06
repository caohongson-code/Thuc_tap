@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h1>Thêm sản phẩm mới</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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
            <input type="number" class="form-control" name="gia_coso" step="0.001" required placeholder="Nhập giá">
        </div>
        <div class="mb-3">
            <label for="id_danhmuc" class="form-label">Danh mục</label>
            <select class="form-control" name="id_danhmuc" required>
                <option value="">Chọn danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->ten }}</option>
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
                <div class="col"><input type="number" name="variants[0][kich_co]" class="form-control" placeholder="Kích cỡ (VD: 30, 40, 50) - đơn vị cm" step="0.1" required></div>
                <div class="col"><input type="number" name="variants[0][gia]" class="form-control" placeholder="Giá (VD: 123.000)" step="0.001" required></div>
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
        let html = `<div class=\"row mb-2 variant-row\">\n            <div class=\"col\"><input type=\"number\" name=\"variants[${variantIndex}][kich_co]\" class=\"form-control\" placeholder=\"Kích cỡ (VD: 30, 40, 50) - đơn vị cm\" step=\"0.1\" required></div>\n            <div class=\"col\"><input type=\"number\" name=\"variants[${variantIndex}][gia]\" class=\"form-control\" placeholder=\"Giá (VD: 123.000)\" step=\"0.001\" required></div>\n            <div class=\"col\"><input type=\"number\" name=\"variants[${variantIndex}][tonkho]\" class=\"form-control\" placeholder=\"Tồn kho\" required></div>\n            <div class=\"col-auto\"><button type=\"button\" class=\"btn btn-danger remove-variant\">X</button></div>\n        </div>`;
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