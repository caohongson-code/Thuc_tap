@extends('admin.layouts.app')
@section('content')
<div class="container">
    <h1>Chi tiết sản phẩm</h1>
    <div class="row mb-3 align-items-center">
        <div class="col-md-8">
            <div class="mb-2"><strong>Tên sản phẩm:</strong> {{ $product->hangcosan }}</div>
            <div class="mb-2"><strong>Mô tả:</strong> {{ $product->mota }}</div>
            <div class="mb-2"><strong>Giá cơ sở:</strong> {{ $product->gia_coso }}</div>
            <div class="mb-2"><strong>Danh mục:</strong> {{ $product->category->ten ?? '' }}</div>
            <div class="mb-2"><strong>Trạng thái:</strong> {{ $product->trang_thai }}</div>
        </div>
        <div class="col-md-4 d-flex justify-content-center">
            @if($product->hinhanh)
                <img src="{{ asset('storage/' . $product->hinhanh) }}" style="max-width:150px; max-height:150px; object-fit:cover; border-radius:10px; box-shadow:0 2px 8px #ccc;">
            @endif
        </div>
    </div>
    <hr>
    <h4>Biến thể sản phẩm</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kích cỡ</th>
                <th>Giá</th>
                <th>Tồn kho</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product->variants as $variant)
            <tr>
                <td>{{ $variant->kich_co }}</td>
                <td>{{ $variant->gia }}</td>
                <td>{{ $variant->tonkho }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Sửa</a>
</div>
@endsection 