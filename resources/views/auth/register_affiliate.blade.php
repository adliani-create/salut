@extends('layouts.app')

@section('title', 'Daftar Sebagai Affiliator')

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .register-container {
        max-width: 500px;
        margin: 5rem auto;
    }
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
    }
    .card-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        text-align: center;
        padding: 2rem 1.5rem;
        border-radius: 1rem 1rem 0 0 !important;
        border-bottom: none;
    }
    .card-body {
        padding: 2.5rem;
    }
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    .btn-primary {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="register-container">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SALUT" height="50" onerror="this.src='https://via.placeholder.com/150x50?text=LOGO'">
        </div>
        
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-badge fs-1 mb-2"></i>
                <h4 class="mb-0 fw-bold">Pendaftaran Affiliator</h4>
                <p class="mb-0 text-white-50 small mt-1">Bergabung menjadi mitra pemasaran resmi kami</p>
            </div>
            
            <div class="card-body">
                @if($mitra)
                    <div class="alert alert-info border-0 bg-info bg-opacity-10 text-info d-flex align-items-center mb-4 rounded-3 p-3">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <span class="d-block small fw-bold">Anda diundang oleh Mitra:</span>
                            <strong class="d-block mt-1">{{ $mitra->name }}</strong>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning border-0 bg-warning bg-opacity-10 text-warning d-flex align-items-center mb-4 rounded-3 p-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <span class="d-block small">Mohon pastikan Anda mendaftar menggunakan link undangan khusus dari Mitra resmi kami.</span>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.affiliate.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="ref" class="form-label text-muted fw-bold small text-uppercase">Kode Mitra Pengundang</label>
                        <input id="ref" type="text" class="form-control bg-light" name="ref" value="{{ $ref }}" readonly>
                        @error('ref')
                            <span class="text-danger small mt-1 d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label text-muted fw-bold small text-uppercase">Nama Lengkap</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama sesuai KTP">
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nim" class="form-label text-muted fw-bold small text-uppercase">Nomor Induk Mahasiswa (NIM)</label>
                        <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required placeholder="Masukkan 9 digit angka NIM Anda">
                        @error('nim')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-muted fw-bold small text-uppercase">Email Aktif</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp" class="form-label text-muted fw-bold small text-uppercase">No. WhatsApp</label>
                        <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 081234567890">
                        @error('whatsapp')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="bank_account" class="form-label text-muted fw-bold small text-uppercase">No. Rekening & Bank</label>
                            <span class="small text-primary fst-italic">Digunakan untuk pencairan komisi</span>
                        </div>
                        <input id="bank_account" type="text" class="form-control @error('bank_account') is-invalid @enderror" name="bank_account" value="{{ old('bank_account') }}" required placeholder="BCA 12345678 a.n Nama Lengkap">
                        @error('bank_account')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label text-muted fw-bold small text-uppercase">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password-confirm" class="form-label text-muted fw-bold small text-uppercase">Konfirmasi Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Daftar Sebagai Affiliator
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none text-muted small hover-primary">
                            Sudah punya akun Affiliator? Masuk di sini.
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
