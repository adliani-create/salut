@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.mitras.index') }}" class="btn btn-light rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="h3 mb-0 text-gray-800">Tambah Mitra Baru</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.mitras.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Data Login & Identitas Pokok</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap (PIC / Individu) <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp') }}" required placeholder="Contoh: 08123456789">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                            <small class="text-muted">Minimal 8 karakter.</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3 border-bottom pb-2">Profil Instansi & Pencairan Transaksi</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Instansi / Perusahaan</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" placeholder="Kosongkan jika mitra perorangan">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Bank</label>
                                <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name') }}" placeholder="BCA / Mandiri / BRI / dll">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">No. Rekening</label>
                                <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Atas Nama Rekening</label>
                            <input type="text" name="bank_account_name" class="form-control" value="{{ old('bank_account_name') }}">
                            <small class="text-muted">Penting: Rekening ini akan dipanggil untuk menu penarikan pencairan komisi.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold">
                        <i class="bi bi-save me-2"></i> Simpan & Generate Akun Mitra
                    </button>
                    <p class="text-muted small mt-2">Kode Referral akan digenerate otomatis setelah disave.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
