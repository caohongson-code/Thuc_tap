@extends('admin.layouts.app')

@section('title', 'Danh sách danh mục')

@section('content')
<div class="container mt-4">
  

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
              <div class="mb-3">
        <a href="" class="btn btn-success w-100">create</a>
    </div>
    <table class="table table-bordered table-hover shadow-sm">
        <thead class="table-success text-center">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
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
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-secondary">Không hoạt động</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> show
                        </a>
                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> edit
                        </a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> delete
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
