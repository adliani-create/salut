@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Material</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.lms-materials.update', $lmsMaterial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $lmsMaterial->title }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="video" {{ $lmsMaterial->type == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="ebook" {{ $lmsMaterial->type == 'ebook' ? 'selected' : '' }}>E-Book (PDF/Doc)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">File (Leave empty to keep current)</label>
                    <input type="file" name="file" class="form-control">
                    <div class="form-text">Current: <a href="{{ asset('storage/' . $lmsMaterial->file_path) }}" target="_blank">View File</a></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $lmsMaterial->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Material</button>
            </form>
        </div>
    </div>
</div>
@endsection
