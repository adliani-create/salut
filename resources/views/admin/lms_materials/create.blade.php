@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Upload Material</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.lms-materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="video">Video</option>
                        <option value="ebook">E-Book (PDF/Doc)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">File</label>
                    <input type="file" name="file" class="form-control" required>
                    <div class="form-text">Max 20MB. Allowed: pdf, mp4, mkv, avi, doc, docx</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection
