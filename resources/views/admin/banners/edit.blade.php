@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Banner</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="hinh_anh" class="form-label">Banner Image</label>
            <input type="file" class="form-control" id="hinh_anh" name="hinh_anh">
            <small class="form-text text-muted">Current image:</small><br>
            <img src="{{ asset($banner->hinh_anh) }}" alt="Banner Image" width="150" class="mt-2">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="hien_thi" name="hien_thi" value="1" {{ $banner->hien_thi ? 'checked' : '' }}>
            <label class="form-check-label" for="hien_thi">Visible</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection 