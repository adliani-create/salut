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
                    <label class="form-label">Kategori</label>
                    <select name="type" class="form-select" required>
                        <option value="video">Video</option>
                        <option value="ebook">E-Book (PDF/Doc)</option>
                        <option value="assignment">Tugas</option>
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
                    <label class="form-label">Sumber Tautan (Source Type)</label>
                    <select name="source_type" class="form-select" required>
                        <option value="youtube">YouTube (Video)</option>
                        <option value="gdrive">Google Drive (E-Book/PDF)</option>
                        <option value="other">Lainnya (Tautan Eksternal)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tautan Materi (URL)</label>
                    <input type="url" name="url" class="form-control" placeholder="https://youtube.com/... atau https://drive.google.com/..." required>
                    <div class="form-text">Masukkan link YouTube atau Google Drive di sini.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3" id="progressContainer" style="display: none;">
                    <label class="form-label">Upload Progress</label>
                    <div class="progress" style="height: 25px;">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                    <small class="text-muted" id="progressText">Uploading...</small>
                </div>

                <div class="alert alert-danger d-none" id="errorAlert"></div>

                <button type="submit" class="btn btn-primary" id="submitBtn">Upload</button>
            </form>
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
