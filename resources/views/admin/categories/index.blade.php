@extends('admin.layouts.app')

@section('title', 'Danh sách danh mục')

@section('content')
<h1>Danh sách danh mục</h1>
<div class="container mt-4">
    <div class="mb-3 text-start">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Thêm danh mục
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif
    <table class="table table-bordered table-hover shadow-sm align-middle">
        <thead class="table-success text-center">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên danh mục</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="text-center">{{ $category->id }}</td>
                    <td>{{ $category->ten }}</td>
                    <td>{{ $category->mieu_ta }}</td>
                    <td class="text-center">
                        @if($category->trang_thai == 'active')
                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Hoạt động</span>
                        @else
                            <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Không hoạt động</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Không có danh mục nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
