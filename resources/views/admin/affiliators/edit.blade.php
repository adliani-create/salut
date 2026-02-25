@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.affiliators.index') }}" class="btn btn-light rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="h3 mb-0 text-gray-800">Edit Data Affiliator</h2>
            <p class="text-muted mb-0">Ubah profil dasar atau status akun affiliator ini.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.affiliators.update', $affiliator) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Kode Referral</label>
                        <input type="text" class="form-control bg-light" value="{{ $affiliator->referral_code }}" readonly>
                        <div class="form-text">Kode referral tidak dapat diubah (Otomatis).</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Upline (Mitra)</label>
                        <input type="text" class="form-control bg-light" value="{{ optional($affiliator->referrer)->name ?? 'Independen (Tanpa Mitra)' }}" readonly>
                        <div class="form-text">Jalur affiliasi tidak dapat dipindah setelah terdaftar.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $affiliator->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $affiliator->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp', $affiliator->whatsapp) }}" placeholder="Contoh: 08123456789">
                        @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold text-danger">Status Akun</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', $affiliator->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="suspended" {{ old('status', $affiliator->status) === 'suspended' ? 'selected' : '' }}>Dibekukan (Suspended)</option>
                        </select>
                        <div class="form-text">Akun yang dibekukan tidak akan bisa dipakai kodenya maupun login ke dashboard.</div>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr class="my-4 border-light">
                
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light me-2 fw-bold">Reset Ulang</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-save me-2"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
