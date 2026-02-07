@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="fw-bold">Upload Transkrip Nilai</h5>
                    <p class="text-muted small">Upload file PDF untuk mengekstrak nilai otomatis.</p>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                        <div class="avatar-placeholder me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->nim }}</small>
                        </div>
                    </div>

                    <form action="{{ route('admin.academic.parse', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Semester</label>
                            <input type="text" name="semester" class="form-control" placeholder="Contoh: 2024.1" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">File Transkrip (PDF)</label>
                            <input type="file" name="transcript_file" class="form-control" accept=".pdf" required>
                            <div class="form-text">Maksimal 5MB. Pastikan format PDF dapat dibaca (bukan scan gambar).</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill py-2 fw-bold">
                                Lanjut ke Verifikasi <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
