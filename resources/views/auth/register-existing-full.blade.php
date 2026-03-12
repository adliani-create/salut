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
                        <div class="row mb-3">
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

                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Jenjang Pendidikan</label>
                                <select name="jenjang" class="form-select form-select-lg @error('jenjang') is-invalid @enderror" required>
                                    <option value="" selected disabled>Pilih...</option>
                                    <option value="S1" {{ old('jenjang') == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                                    <option value="S2" {{ old('jenjang') == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                                </select>
                                @error('jenjang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Fakultas</label>
                                <select name="fakultas_id" id="fakultasSelectExisting" class="form-select form-select-lg @error('fakultas_id') is-invalid @enderror" required onchange="loadProdisExisting(this.value)">
                                    <option value="" selected disabled>Pilih Fakultas...</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}">{{ $f->nama }}</option>
                                    @endforeach
                                </select>
                                @error('fakultas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-muted">Program Studi</label>
                                <select name="prodi_id" id="prodiSelectExisting" class="form-select form-select-lg @error('prodi_id') is-invalid @enderror" required disabled>
                                    <option value="" selected disabled>Pilih Fakultas Dulu...</option>
                                </select>
                                @error('prodi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <script>
                            function loadProdisExisting(fakultasId) {
                                if (!fakultasId) return;

                                const prodiSelect = document.getElementById('prodiSelectExisting');
                                prodiSelect.disabled = true;
                                prodiSelect.innerHTML = '<option value="" selected>Loading...</option>';

                                fetch(`{{ url('ajax/fakultas') }}/${fakultasId}/prodis`)
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        prodiSelect.innerHTML = '<option value="" selected disabled>Pilih Prodi...</option>';
                                        data.forEach(prodi => {
                                            const option = document.createElement('option');
                                            option.value = prodi.id; // Send ID
                                            option.text = prodi.nama + ' (' + prodi.jenjang + ')';
                                            prodiSelect.appendChild(option);
                                        });
                                        prodiSelect.disabled = false;
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        prodiSelect.innerHTML = '<option value="" selected disabled>Gagal memuat prodi</option>';
                                    });
                            }
                        </script>

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
                                @foreach($programs as $program)
                                @php
                                    // Assign icon based on name similarity (since DB doesn't store icon class)
                                    $icon = 'bi-mortarboard-fill';
                                    if(str_contains($program->name, 'Wirausaha')) $icon = 'bi-rocket-takeoff-fill';
                                    elseif(str_contains($program->name, 'Magang')) $icon = 'bi-building-fill';
                                    elseif(str_contains($program->name, 'Skill')) $icon = 'bi-laptop';
                                    elseif(str_contains($program->name, 'Creator') || str_contains($program->name, 'Affiliator')) $icon = 'bi-phone-fill';
                                @endphp
                                <div class="col-md-6">
                                    <label class="card h-100 border-success cursor-pointer option-card">
                                        <div class="card-body d-flex align-items-center">
                                            <input type="radio" name="fokus_karir" value="{{ $program->name }}" class="form-check-input me-3" required {{ old('fokus_karir') == $program->name ? 'checked' : '' }}>
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
                        </div>

                        <div class="d-grid gap-2 mt-5 pt-3">
                            <button type="submit" class="btn btn-success btn-lg py-3 fw-bold shadow-sm">
                                <i class="bi bi-check-circle-fill me-2"></i> Daftar & Ajukan Verifikasi
                            </button>
                            <a href="{{ route('register') }}" class="btn btn-link text-muted mt-2">Batal & Kembali</a>
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
