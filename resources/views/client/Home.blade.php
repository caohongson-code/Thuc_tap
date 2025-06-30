@extends('client.layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-3 ">
            <div class="product">
                <a href="#" class="img-prod">
                    <img class="img-fluid" src="https://www.vietnamworks.com/hrinsider/wp-content/uploads/2023/12/anh-thien-nhien-3d-005.jpg" alt="Colorlib Template">
                    <div class="overlay"></div>
                </a>
                <div class="text py-3 pb-4 px-3 text-center">
                    <h3><a href="#">Fruit Juice</a></h3>
                    <div class="d-flex">
                        <div class="pricing">
                            <p class="price"><span>$120.00</span></p>
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
    </div>
</div>
@endsection
