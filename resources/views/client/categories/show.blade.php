@extends('client.layouts.main')

@php use Illuminate\Support\Str; @endphp

@section('content')
<section>
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">{{ $category->ten }}</h1>
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span>
                    <span class="mr-2"><a href="{{ route('client.categories.index') }}">Danh mục <i class="ion-ios-arrow-forward"></i></a></span>
                    <span>{{ $category->ten }}</span>
                </p>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <h2 class="text-center mb-5 font-weight-bold">Sản phẩm trong danh mục "{{ $category->ten }}"</h2>
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm product-card">
                <a href="{{ route('client.show', $product->id) }}" class="position-relative">
                    <img src="{{ asset('/' . $product->hinhanh) }}" class="card-img-top" alt="{{ $product->ten_san_pham }}" style="height:220px; object-fit:cover;">
                    <span class="badge badge-success position-absolute" style="top: 10px; left: 10px;">{{ $category->ten }}</span>
                </a>
                <div class="card-body d-flex flex-column text-center">
                    <h5 class="card-title mb-2">{{ $product->ten_san_pham }}</h5>
                    <p class="text-danger font-weight-bold">{{ number_format($product->gia_coso, 0, ',', '.') }}₫</p>
                    <div class="mt-auto">
                        <a href="{{ route('client.show', $product->id) }}" class="btn btn-outline-primary btn-sm mb-2 w-100">
                            <i class="ion-ios-eye"></i> Xem chi tiết
                        </a>
                        <a href="#" class="btn btn-success btn-sm w-100">
                            <i class="ion-ios-cart"></i> Thêm vào giỏ
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                Không có sản phẩm nào trong danh mục này.
            </div>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>

<style>
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    transition: 0.3s ease;
}
</style>
@endsection
