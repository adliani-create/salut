@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header bg-success text-white text-center py-4">
                    <h3 class="font-weight-light my-2">Update Data Mahasiswa</h3>
                    <p class="mb-0 text-white-50">Halo, {{ $user->name }}! Silakan lengkapi data terbaru Anda.</p>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register.existing.store') }}">
                        @csrf
                        
                        <!-- Readonly Identity -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">NIM</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->nim }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted">Nama Lengkap</label>
                                <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Contact Update -->
                        <h5 class="text-success mb-3"><i class="bi bi-person-lines-fill me-2"></i>Update Kontak</h5>
                        <div class="row mb-3">
                             <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email Aktif</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="whatsapp" class="form-label fw-bold">No. WhatsApp Aktif</label>
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input id="whatsapp" type="text" class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp" value="{{ old('whatsapp', $user->registration->whatsapp ?? '') }}" required placeholder="812xxxxxx">
                                </div>
                                @error('whatsapp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Academic Update -->
                        <h5 class="text-success mb-3"><i class="bi bi-mortarboard-fill me-2"></i>Data Akademik Saat Ini</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="semester" class="form-label fw-bold">Semester Berjalan</label>
                                <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                    <option value="">Pilih Semester...</option>
                                    @foreach(range(1, 14) as $sem)
                                        <option value="{{ $sem }}" {{ old('semester', $user->semester) == $sem ? 'selected' : '' }}>Semester {{ $sem }}</option>
                                    @endforeach
                                </select>
                                @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="angkatan" class="form-label fw-bold">Angkatan (Tahun Masuk)</label>
                                <input id="angkatan" type="number" class="form-control @error('angkatan') is-invalid @enderror" name="angkatan" value="{{ old('angkatan', $user->angkatan) }}" required placeholder="20xx">
                                @error('angkatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Career Focus -->
                        <h5 class="text-success mb-3"><i class="bi bi-stars me-2"></i>Pilih Program Unggulan (Wajib)</h5>
                        <div class="alert alert-info small">
                            <i class="bi bi-info-circle me-1"></i> Sebagai mahasiswa aktif, Anda diwajibkan memilih satu program unggulan untuk pengembangan karir.
                        </div>
                        
                        <div class="row g-3">
                            @foreach($programs as $program)
                            @php
                                $icon = 'bi-mortarboard-fill';
                                if(str_contains($program->name, 'Wirausaha')) $icon = 'bi-rocket-takeoff-fill';
                                elseif(str_contains($program->name, 'Magang')) $icon = 'bi-building-fill';
                                elseif(str_contains($program->name, 'Skill')) $icon = 'bi-laptop';
                                elseif(str_contains($program->name, 'Creator') || str_contains($program->name, 'Affiliator')) $icon = 'bi-phone-fill';
                            @endphp
                            <div class="col-md-6">
                                <label class="card h-100 border-success cursor-pointer option-card">
                                    <div class="card-body d-flex align-items-center">
                                        <input type="radio" name="fokus_karir" value="{{ $program->name }}" class="form-check-input me-3" required {{ old('fokus_karir', $user->registration->fokus_karir ?? '') == $program->name ? 'checked' : '' }}>
                                        <div>
                                            <i class="bi {{ $icon }} fs-4 text-success mb-2 d-block"></i>
                                            <span class="fw-bold">{{ $program->name }}</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                         @error('fokus_karir') <div class="text-danger small mt-2">{{ $message }}</div> @enderror

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-success btn-lg">
                                Simpan Data & Masuk Dashboard <i class="bi bi-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    .option-card:hover { background-color: #f8fff9; }
    .form-check-input:checked + div { color: #198754; }
</style>
@endsection
