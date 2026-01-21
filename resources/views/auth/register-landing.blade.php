@extends('layouts.app')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 justify-content-center g-4">
        
        <div class="col-12 text-center mb-4">
            <h1 class="fw-bold text-primary">Selamat Datang di SALUT Indo Global</h1>
            <p class="text-muted fs-5">Silakan pilih status mahasiswa Anda untuk melanjutkan</p>
        </div>

        <!-- Option A: New Student -->
        <div class="col-md-5">
            <div class="card h-100 shadow-lg border-0 hover-scale" style="transition: transform 0.3s;">
                <div class="card-body p-5 text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                            <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Saya Mahasiswa Baru</h3>
                        <p class="text-muted mb-4">
                            Pilih opsi ini jika Anda <strong>belum memiliki NIM</strong> atau baru akan mendaftar ke Universitas Terbuka melalui SALUT.
                        </p>
                        <ul class="text-start text-muted mb-4 small">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Daftar Akun Baru</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Lengkapi Data Diri</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pilih Program Unggulan</li>
                        </ul>
                    </div>
                    <a href="{{ route('register.new') }}" class="btn btn-primary btn-lg w-100 rounded-pill">
                        Daftar Maba <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Option B: Existing Student -->
        <div class="col-md-5">
            <div class="card h-100 shadow-lg border-0 hover-scale" style="transition: transform 0.3s;">
                <div class="card-body p-5 text-center d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-success bg-opacity-10 p-4 rounded-circle d-inline-block mb-4">
                            <i class="bi bi-person-badge-fill text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Saya Mahasiswa Aktif</h3>
                        <p class="text-muted mb-4">
                            Pilih opsi ini jika Anda <strong>sudah memiliki NIM</strong> dan ingin melakukan aktivasi akun, daftar ulang, atau memilih program unggulan.
                        </p>
                        <ul class="text-start text-muted mb-4 small">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Verifikasi NIM & Data</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Update Kontak</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pilih Program Unggulan</li>
                        </ul>
                    </div>
                    <a href="{{ route('register.existing') }}" class="btn btn-outline-success btn-lg w-100 rounded-pill">
                        Masuk / Aktivasi <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .hover-scale:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
