@extends('layouts.affiliator')

@section('title', 'Input Affiliator Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-primary text-white border-0 py-3 rounded-top-4">
                <h5 class="fw-bold mb-0"><i class="bi bi-person-plus-fill me-2"></i>Form Input Calon Affiliator</h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <p class="text-muted mb-4">Gunakan form ini untuk mencatat data prospek (kandidat affiliator) yang tertarik bergabung sebelum mereka mendaftar mandiri via link.</p>

                <form action="{{ route('affiliator.students.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Lengkap<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light"><i class="bi bi-whatsapp text-success"></i></span>
                            <input type="number" name="whatsapp" class="form-control form-control-lg @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" required placeholder="Contoh: 081234567890">
                            @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Asal Kampus / Pekerjaan <span class="text-muted">(Opsional)</span></label>
                        <input type="text" name="school_origin" class="form-control form-control-lg @error('school_origin') is-invalid @enderror" value="{{ old('school_origin') }}">
                        @error('school_origin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Instansi <span class="text-muted">(Opsional)</span></label>
                        <input type="text" name="program_interest" class="form-control form-control-lg @error('program_interest') is-invalid @enderror" value="{{ old('program_interest') }}">
                        @error('program_interest') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                        <a href="{{ route('affiliator.students.index') }}" class="btn btn-light btn-lg px-4 me-md-2 fw-bold text-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold"><i class="bi bi-save me-2"></i>Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
