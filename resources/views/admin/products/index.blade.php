@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h1>Danh sách sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Thêm sản phẩm</a>
    <form method="GET" action="" class="mb-3 d-flex" style="max-width:400px">
        <input type="text" name="q" class="form-control me-2" placeholder="Tìm kiếm tên sản phẩm..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Danh mục</th>
                <th>Giá cơ sở</th>
                <th>Trạng thái</th>
                <th>Biến thể</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->ten_san_pham }}</td>
                <td>
                    @if($product->hinhanh)
                        <img src="{{ asset($product->hinhanh) }}" width="80">
                    @endif
                </td>
                <td>{{ $product->category->ten ?? '' }}</td>
                <td>{{ number_format($product->gia_coso, 3, '.', '.') }}</td>
                <td>{{ $product->trang_thai }}</td>
                <td>
                    @foreach($product->variants as $variant)
                        <div>Size: {{ $variant->kich_co }} cm, Giá: {{ number_format($variant->gia, 0, '.', '.') }}, Tồn kho: {{ $variant->tonkho }}</div>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm">Xem</a>
<a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Sửa</a>
<form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  
    <div class="d-flex flex-column align-items-center mt-4">
        <div class="mb-2">
            {{ $products->links('pagination::simple-bootstrap-5') }}
        </div>
        <div>
            {{ __('Showing :from to :to of :total results', [
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
                'total' => $products->total()
            ]) }}
        </div>
    </div>
</div>
@endsection
