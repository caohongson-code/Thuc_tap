@extends('admin.layouts.app')

@section('title', 'Sửa danh mục')

@section('content')
<div class="container mt-4">
    <h2>Sửa danh mục</h2>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="ten" class="form-label">Tên danh mục</label>
            <input type="text" class="form-control" id="ten" name="ten" value="{{ old('ten', $category->ten) }}" required>
            @error('ten')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="mieu_ta" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mieu_ta" name="mieu_ta">{{ old('mieu_ta', $category->mieu_ta) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select class="form-control" id="trang_thai" name="trang_thai" required>
                <option value="active" {{ old('trang_thai', $category->trang_thai) == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ old('trang_thai', $category->trang_thai) == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
