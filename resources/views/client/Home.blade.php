@extends('client.layouts.main')

@section('content')
<div class="container">
<form action="{{ route('home') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
    </div>
</form>


    @if(request()->get('page', 1) == 1 && !request()->filled('search'))
    <h1>Sản phẩm hot</h1>
    <div class="row">
        @foreach($latestProducts as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="product">
                <a href="{{ route('client.show', $product->id) }}" class="img-prod">
                    <img class="img-fluid" src="{{ asset('/' . $product->hinhanh) }}" alt="{{ $product->ten_san_pham }}">
                </a>
                <div class="text py-3 pb-4 px-3 text-center">
                    <h3><a href="#">{{ $product->ten_san_pham }}</a></h3>
                    <div class="d-flex">
                        <div class="pricing">
                            <p class="price"><span>{{ number_format($product->gia_coso, 0, ',', '.') }}₫</span></p>
                        </div>
                    </div>
                    <div class="bottom-area d-flex px-3">
                        <div class="m-auto d-flex">
                            <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                <span><i class="ion-ios-menu"></i></span>
                            </a>
                            <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                <span><i class="ion-ios-cart"></i></span>
                            </a>
                            <a href="#" class="heart d-flex justify-content-center align-items-center">
                                <span><i class="ion-ios-heart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

    @if(!request()->filled('search'))
<h1>sản phẩm bán chạy</h1>
    @endif


    <div class="row">
        @foreach($products as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="product">
                <a href="{{ route('client.show', $product->id) }}" class="img-prod">
                    <img class="img-fluid" src="{{ asset('/' . $product->hinhanh) }}" alt="{{ $product->ten_san_pham }}">
 </a>
                    
               

                <div class="text py-3 pb-4 px-3 text-center">
                    <h3><a href="#">{{ $product->ten_san_pham }}</a></h3>
                    <div class="d-flex">
                        <div class="pricing">
                            <p class="price"><span>{{ number_format($product->gia_coso, 0, ',', '.') }}₫</span></p>
                        </div>
                    </div>
                    <div class="bottom-area d-flex px-3">
                        <div class="m-auto d-flex">
                            <a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                <span><i class="ion-ios-menu"></i></span>
                            </a>
                            <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                <span><i class="ion-ios-cart"></i></span>
                            </a>
                            <a href="#" class="heart d-flex justify-content-center align-items-center">
                                <span><i class="ion-ios-heart"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
</div>        <div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>
<br>
@endsection
