@extends('layouts.admin')

@section('title', 'Detail Registrasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">Verifikasi Registrasi</h5>
                <a href="{{ route('admin.registrations.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Nama Lengkap</div>
                    <div class="col-md-8 fw-bold">{{ $registration->user->name ?? 'N/A' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Email</div>
                    <div class="col-md-8">{{ $registration->user->email ?? 'N/A' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Whatsapp</div>
                    <div class="col-md-8">{{ $registration->whatsapp ?? '-' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Jenjang</div>
                    <div class="col-md-8">{{ $registration->jenjang ?? '-' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Fakultas</div>
                    <div class="col-md-8">{{ $registration->fakultas ?? '-' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Prodi</div>
                    <div class="col-md-8">{{ $registration->prodi ?? '-' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Jalur</div>
                    <div class="col-md-8">{{ $registration->jalur_pendaftaran ?? '-' }}</div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4 text-muted">Fokus Karir</div>
                    <div class="col-md-8 fw-bold text-success">{{ $registration->fokus_karir ?? '-' }}</div>
                </div>
                
                <hr class="my-4">

                <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Validasi</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="valid" {{ $registration->status == 'valid' ? 'selected' : '' }}>Valid (Terima)</option>
                            <option value="invalid" {{ $registration->status == 'invalid' ? 'selected' : '' }}>Invalid (Tolak)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan Admin (Opsional)</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Alasan penolakan atau catatan tambahan...">{{ $registration->admin_notes }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
