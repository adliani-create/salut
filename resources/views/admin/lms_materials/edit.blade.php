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
                    <label class="form-label">Sumber Tautan (Source Type)</label>
                    <select name="source_type" class="form-select" required>
                        <option value="youtube" {{ $lmsMaterial->source_type == 'youtube' ? 'selected' : '' }}>YouTube (Video)</option>
                        <option value="gdrive" {{ $lmsMaterial->source_type == 'gdrive' ? 'selected' : '' }}>Google Drive (E-Book/PDF)</option>
                        <option value="other" {{ $lmsMaterial->source_type == 'other' ? 'selected' : '' }}>Lainnya (Tautan Eksternal)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tautan Materi (URL)</label>
                    <input type="url" name="url" class="form-control" value="{{ $lmsMaterial->url }}" placeholder="https://youtube.com/... atau https://drive.google.com/..." required>
                    <div class="form-text">Masukkan link YouTube atau Google Drive di sini.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $lmsMaterial->description }}</textarea>
                </div>
                <div class="mb-3" id="progressContainer" style="display: none;">
                    <label class="form-label">Upload Progress</label>
                    <div class="progress" style="height: 25px;">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <small class="text-muted" id="progressText">Uploading...</small>
                </div>

                <div class="alert alert-danger d-none" id="errorAlert"></div>

                <button type="submit" class="btn btn-primary" id="submitBtn">Update Material</button>
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
