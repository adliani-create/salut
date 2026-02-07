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
                    <label class="form-label">File</label>
                    <input type="file" name="file" class="form-control" required>
                    <div class="form-text">Max 20MB. Allowed: pdf, mp4, mkv, avi, doc, docx</div>
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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('checkAllPrograms').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="career_program_ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const errorAlert = document.getElementById('errorAlert');

    form.addEventListener('submit', function(e) {
        // Only intercept if file is selected (which is required here)
        const fileInput = document.querySelector('input[name="file"]');
        if (fileInput.files.length > 0) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...';
            progressContainer.style.display = 'block';
            errorAlert.classList.add('d-none');
            
            const formData = new FormData(form);
            
            axios.post(form.action, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                onUploadProgress: function(progressEvent) {
                    const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressBar.style.width = percentCompleted + '%';
                    progressBar.innerHTML = percentCompleted + '%';
                    progressBar.setAttribute('aria-valuenow', percentCompleted);
                    
                    if(percentCompleted === 100) {
                        progressText.innerHTML = 'Processing file... please wait.';
                        progressBar.classList.remove('progress-bar-animated');
                        progressBar.classList.add('bg-success');
                    } else {
                        progressText.innerHTML = `Uploaded ${bytesToSize(progressEvent.loaded)} of ${bytesToSize(progressEvent.total)}`;
                    }
                }
            })
            .then(function (response) {
                window.location.href = "{{ route('admin.lms-materials.index') }}";
            })
            .catch(function (error) {
                console.error(error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Upload';
                progressContainer.style.display = 'none';
                progressBar.style.width = '0%';
                
                let errorMsg = 'An error occurred during upload.';
                
                if (error.response) {
                    // Check for specific status codes
                    if (error.response.status === 413) {
                        errorMsg = 'File too large. Please check your PHP configuration (upload_max_filesize).';
                    } else if (error.response.status === 422) {
                        if (error.response.data.errors) {
                            const errors = Object.values(error.response.data.errors).flat();
                            errorMsg = errors.join('<br>');
                        } else {
                            errorMsg = error.response.data.message || 'Validation Error';
                        }
                    } else if (error.response.status === 500) {
                        errorMsg = 'Server Error. Please check server logs or configuration.';
                    } else if (error.response.data && error.response.data.message) {
                        errorMsg = error.response.data.message;
                    }
                } else if (error.request) {
                    errorMsg = 'Network Error. Please check your connection.';
                }

                errorAlert.innerHTML = errorMsg;
                errorAlert.classList.remove('d-none');
            });
        }
    });

    function bytesToSize(bytes) {
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes === 0) return '0 Byte';
        const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }
</script>
@endsection
