@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Quản lý bình luận</h2>
    <form method="GET" action="" class="mb-3 d-flex" style="max-width:400px">
        <input type="text" name="q" class="form-control me-2" placeholder="Tìm kiếm nội dung, tên khách hàng..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-outline-primary">Tìm kiếm</button>
    </form>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <td>{{ $comment->id }}</td>
                <td>{{ $comment->product->ten_san_pham ?? 'N/A' }}</td>
                <td>{{ ($comment->user->ho ?? '') . ' ' . ($comment->user->ten ?? '') }}</td>
                <td>{{ $comment->noi_dung }}</td>
                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $comments->links() }}
</div>
@endsection 