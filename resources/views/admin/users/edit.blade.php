@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Sửa tài khoản</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="ho" class="form-label">Họ</label>
            <input type="text" class="form-control" id="ho" name="ho" value="{{ old('ho', $user->ho) }}" required>
        </div>
        <div class="mb-3">
            <label for="ten" class="form-label">Tên</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{ old('ten', $user->ten) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="matkhau" class="form-label">Mật khẩu mới (bỏ trống nếu không đổi)</label>
            <input type="password" class="form-control" id="matkhau" name="matkhau">
        </div>
        <div class="mb-3">
            <label for="dien_thoai" class="form-label">Điện thoại</label>
            <input type="text" class="form-control" id="dien_thoai" name="dien_thoai" value="{{ old('dien_thoai', $user->dien_thoai) }}" required>
        </div>
        <div class="mb-3">
            <label for="dia_chi" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="dia_chi" name="dia_chi" value="{{ old('dia_chi', $user->dia_chi) }}" required>
        </div>
        <div class="mb-3">
            <label for="thanhpho" class="form-label">Thành phố</label>
            <input type="text" class="form-control" id="thanhpho" name="thanhpho" value="{{ old('thanhpho', $user->thanhpho) }}" required>
        </div>
        <div class="mb-3">
            <label for="vai_tro" class="form-label">Vai trò</label>
            <select class="form-control" id="vai_tro" name="vai_tro" required>
                <option value="user" {{ old('vai_tro', $user->vai_tro) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('vai_tro', $user->vai_tro) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection 