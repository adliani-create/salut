@extends('layouts.admin')

@section('title', 'Upload Material')

@section('content')
<div class="container-fluid">
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
                    <label class="form-label">Program Salut (Target Audience)</label>
                    <div class="card p-3 bg-light">
                        <div class="row">
                            @foreach($programs as $program)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="career_program_ids[]" value="{{ $program->id }}" id="program_{{ $program->id }}">
                                        <label class="form-check-label" for="program_{{ $program->id }}">
                                            {{ $program->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="video">Video</option>
                        <option value="ebook">E-Book (PDF/Doc)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thumbnail (Optional)</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    <div class="form-text">Cover image for the material. Max 2MB.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration / Metadata</label>
                    <input type="text" name="duration" class="form-control" placeholder='e.g. "10 Menit", "50 Halaman"'>
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
