@extends('client.layouts.main')
@php use Illuminate\Support\Str; @endphp

@section('content')
<section class=" hero-wrap-2">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">Danh Mục Sản Phẩm</h1>
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ route('home') }}">Trang chủ <i class="ion-ios-arrow-forward"></i></a></span>
                    <span>Danh mục</span>
                </p>
            </div>
        </div>
    </div>
</section>

<div class="container mt-5 mb-5">
    <h2 class="text-center font-weight-bold mb-4">Tất Cả Danh Mục</h2>
    <div class="row justify-content-center">
        @forelse($categories as $category)
        <div class="col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
            <div class="card shadow-sm w-100 h-100 border-0 category-card" style="transition: box-shadow 0.2s;">
                {{-- <div class="position-relative">
                    <img src="https://via.placeholder.com/300x200?text=Category" class="card-img-top" alt="{{ $category->ten }}" style="height:180px;object-fit:cover;">
                </div> --}}
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center">{{ $category->ten }}</h5>
                    <p class="card-text text-center text-muted">{{ $category->mieu_ta ? Str::limit($category->mieu_ta, 50) : 'Không có mô tả' }}</p>
                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-outline-primary mt-auto mx-auto">Xem sản phẩm</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">Không có danh mục nào.</div>
        </div>
        @endforelse
    </div>
</div>

<style>
.category-card:hover {
    box-shadow: 0 4px 24px 0 rgba(0,0,0,0.12);
    transform: translateY(-4px);
}
</style>
@endsection
