@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold">Upload Kartu Ujian (KTPU)</h5>
                    <p class="text-muted small">Upload file KTPU untuk mahasiswa ini.</p>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <div class="avatar-placeholder me-3 bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-card-heading"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->nim }}</small>
                        </div>
                    </div>

                    <form action="{{ route('admin.academic.ktpu.store', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Semester</label>
                            <input type="text" name="semester" class="form-control" placeholder="Contoh: 2024.1" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">File KTPU (PDF/Image)</label>
                            <input type="file" name="ktpu_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Maksimal 5MB. Format: PDF, JPG, PNG.</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning fw-bold rounded-pill py-2">
                                <i class="bi bi-upload me-2"></i> Upload KTPU
                            </button>
                            <a href="{{ route('admin.academic.index') }}" class="btn btn-link text-muted mt-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
