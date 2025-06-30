@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Add New Banner</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="hinh_anh" class="form-label">Banner Image</label>
            <input type="file" class="form-control" id="hinh_anh" name="hinh_anh" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="hien_thi" name="hien_thi" value="1" checked>
            <label class="form-check-label" for="hien_thi">Visible</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 