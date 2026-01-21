@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
                <div class="card-header bg-success text-white py-4">
                    <div class="text-center">
                        <h3 class="font-weight-light mb-1">Registrasi Mahasiswa Aktif</h3>
                        <p class="mb-0 text-white-50">Lengkapi formulir di bawah ini untuk aktivasi akun portal.</p>
                    </div>
                </div>
                <div class="card-body p-5">
                    @if (session('error'))
                        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register.existing.store') }}">
                        @csrf

                        <!-- Section 1: Identitas Akademik -->
                        <h5 class="text-success fw-bold mb-3 border-bottom pb-2">
                            <i class="bi bi-person-badge-fill me-2"></i>Identitas Akademik
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">NIM</label>
                                <input type="number" class="form-control form-control-lg @error('nim') is-invalid @enderror" name="nim" value="{{ old('nim') }}" required placeholder="Contoh: 041xxxxxx">
                                @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Sesuai KTM">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Angkatan</label>
                                <select name="angkatan" class="form-select form-select-lg @error('angkatan') is-invalid @enderror" required>
                                    <option value="" selected disabled>Pilih Tahun...</option>
                                    @for($i = date('Y'); $i >= 2015; $i--)
                                        <option value="{{ $i }}" {{ old('angkatan') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                @error('angkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Section 2: Akun Login -->
                        <h5 class="text-success fw-bold mb-3 border-bottom pb-2 mt-5">
                            <i class="bi bi-shield-lock-fill me-2"></i>Buat Akun Login
                        </h5>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Email Aktif</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                                <div class="form-text">Digunakan untuk login dan reset password.</div>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Ulangi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <!-- Section 3: Data Update -->
                        <h5 class="text-success fw-bold mb-3 border-bottom pb-2 mt-5">
                            <i class="bi bi-box-arrow-in-up me-2"></i>Update Data
                        </h5>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">No. WhatsApp Aktif</label>
                            <div class="input-group">
                                <span class="input-group-text">+62</span>
                                <input type="number" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="812xxxxxx">
                            </div>
                            @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3 d-block">Pilih Program Unggulan</label>
                            <div class="row g-3">
                                @foreach(['Kuliah Plus Wirausaha' => 'bi-rocket-takeoff-fill', 
                                          'Kuliah Plus Magang Kerja' => 'bi-building-fill', 
                                          'Kuliah Plus Skill Academy' => 'bi-laptop', 
                                          'Kuliah Plus Creator / Affiliator' => 'bi-phone-fill'] as $prog => $icon)
                                <div class="col-md-6">
                                    <label class="card h-100 border-success cursor-pointer option-card">
                                        <div class="card-body d-flex align-items-center">
                                            <input type="radio" name="fokus_karir" value="{{ $prog }}" class="form-check-input me-3" required {{ old('fokus_karir') == $prog ? 'checked' : '' }}>
                                            <div>
                                                <i class="bi {{ $icon }} fs-4 text-success mb-2 d-block"></i>
                                                <span class="fw-bold">{{ $prog }}</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('fokus_karir') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2 mt-5 pt-3">
                            <button type="submit" class="btn btn-success btn-lg py-3 fw-bold shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i> Daftar & Ajukan Verifikasi
                            </button>
                            <a href="{{ route('register.landing') }}" class="btn btn-link text-muted mt-2">Batal & Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .option-card:hover { background-color: #f8fff9; transform: translateY(-2px); transition: all 0.2s; }
    .form-check-input:checked + div { color: #198754; }
</style>
@endsection
