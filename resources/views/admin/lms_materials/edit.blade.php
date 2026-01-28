@extends('layouts.admin')

@section('title', 'Edit Material')

@section('content')
<div class="container-fluid">
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
                    <label class="form-label">Program Sasaran (Target Audience)</label>
                    <div class="card p-3 bg-light">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="checkAllPrograms">
                            <label class="form-check-label fw-bold" for="checkAllPrograms">
                                ⚪ Semua Program (General)
                            </label>
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            @foreach($programs as $program)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="career_program_ids[]" value="{{ $program->id }}" id="program_{{ $program->id }}"
                                            {{ in_array($program->id, $lmsMaterial->careerPrograms->pluck('id')->toArray()) ? 'checked' : '' }}>
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
                    <label class="form-label">Kategori</label>
                    <select name="type" class="form-select" required>
                        <option value="video" {{ $lmsMaterial->type == 'video' ? 'selected' : '' }}>Video</option>
                        <option value="ebook" {{ $lmsMaterial->type == 'ebook' ? 'selected' : '' }}>E-Book (PDF/Doc)</option>
                        <option value="assignment" {{ $lmsMaterial->type == 'assignment' ? 'selected' : '' }}>Tugas</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thumbnail (Optional)</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    @if($lmsMaterial->thumbnail)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $lmsMaterial->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" width="150">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration / Metadata</label>
                    <input type="text" name="duration" class="form-control" value="{{ $lmsMaterial->duration }}" placeholder='e.g. "10 Menit", "50 Halaman"'>
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
    </div>
</div>

<script>
    document.getElementById('checkAllPrograms').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="career_program_ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
