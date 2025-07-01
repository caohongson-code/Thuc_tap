@extends('client.layouts.main')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-success">
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><img src="https://gaubongonline.vn/wp-content/uploads/2023/07/gau-bong-mup-mip-1.jpg" width="70"></td>
                    <td>Gấu bông Múp Míp</td>
                    <td>150.000đ</td>
                    <td><input type="number" class="form-control w-50 mx-auto" value="2" min="1"></td>
                    <td>300.000đ</td>
                    <td><button class="btn btn-danger btn-sm">Xóa</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><img src="https://gaubongonline.vn/wp-content/uploads/2023/07/gau-bong-cao-cap-1.jpg" width="70"></td>
                    <td>Gấu bông Cao Cấp</td>
                    <td>250.000đ</td>
                    <td><input type="number" class="form-control w-50 mx-auto" value="1" min="1"></td>
                    <td>250.000đ</td>
                    <td><button class="btn btn-danger btn-sm">Xóa</button></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row justify-content-end">
        <div class="col-md-4">
            <div class="card p-3">
                <h5 class="mb-3">Tổng cộng: <span class="text-success">550.000đ</span></h5>
                <button class="btn btn-primary w-100 mb-2">Cập nhật giỏ hàng</button>
                <button class="btn btn-success w-100">Thanh toán</button>
            </div>
        </div>
    </div>
</div>
@endsection 