@extends('layouts.app')

@section('content')
<!-- Navbar is handled by layouts.app, ensuring sticky behavior and standard links -->

<!-- Hero Section -->
<section class="hero-section text-white text-center d-flex align-items-center" style="background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(0, 0, 0, 0.6)), url('https://source.unsplash.com/1600x900/?university,student'); background-size: cover; background-position: center; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Kuliah Fleksibel, Kualitas Dunia</h1>
                <p class="lead mb-5 animate__animated animate__fadeInUp">Bergabunglah dengan SALUT Indo Global. Akses pendidikan tinggi berkualitas dari Universitas Terbuka dengan dukungan layanan prima.</p>
                <div class="animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary fw-bold me-3 px-4 rounded-pill">Daftar Sekarang</a>
                    <a href="#about" class="btn btn-outline-light btn-lg px-4 rounded-pill">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="https://source.unsplash.com/800x600/?office,meeting" alt="About SALUT" class="img-fluid rounded-3 shadow-lg">
            </div>
            <div class="col-md-6 ps-md-5">
                <h6 class="text-primary fw-bold text-uppercase ls-wide">Tentang Kami</h6>
                <h2 class="display-5 fw-bold mb-4">SALUT Indo Global</h2>
                <p class="lead text-secondary mb-4">Sentra Layanan UT (SALUT) adalah perpanjangan tangan Universitas Terbuka yang hadir lebih dekat dengan Anda. Kami menyediakan fasilitas dan layanan administrasi akademik serta kegiatan pengembangan diri.</p>
                <p>Kenapa memilih kami?</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Fleksibilitas waktu belajar</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Biaya terjangkau</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Kualitas pendidikan terakreditasi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Fakultas Section -->
<section id="fakultas" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">Pilihan Studi</h6>
            <h2 class="display-5 fw-bold">Fakultas & Program Studi</h2>
            <p class="text-secondary w-75 mx-auto">Temukan minat dan bakat Anda di berbagai pilihan fakultas yang kami sediakan.</p>
        </div>

        <div class="row g-4">
            @forelse($fakultas as $f)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4 text-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-mortarboard fs-2"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">{{ $f->nama_fakultas }}</h4>
                        <!-- You can list prodi here if relation exists, or just a generic description -->
                        <p class="card-text text-secondary mb-4">Program studi unggulan untuk mempersiapkan karir masa depan Anda.</p>
                        <a href="#" class="btn btn-outline-primary rounded-pill btn-sm">Lihat Jurusan</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada data fakultas.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">Layanan Kami</h6>
            <h2 class="display-5 fw-bold">Support System Terbaik</h2>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Layanan Akademik -->
            <div class="col-md-5">
                <div class="card h-100 border-0 shadow-lg text-white" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="bi bi-book-half display-4"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Layanan Akademik</h3>
                        <p class="mb-4">Fokus pada kelancaran studi dan administrasi Anda.</p>
                        <ul class="list-unstyled opacity-75">
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Registrasi Mata Kuliah</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Bantuan Tutorial Tatap Muka</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Pengurusan Kelulusan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Layanan Non-Akademik -->
            <div class="col-md-5">
                <div class="card h-100 border-0 shadow-lg text-white" style="background: linear-gradient(45deg, #6610f2, #d63384);">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <i class="bi bi-laptop display-4"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Layanan Non-Akademik</h3>
                        <p class="mb-4">Pengembangan soft-skill dan hard-skill untuk dunia kerja.</p>
                        <ul class="list-unstyled opacity-75">
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Webinar Naik Kelas</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Pelatihan Skill Digital</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Akses LMS Lokal (Materi Ekstra)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3 text-primary">SALUT Indo Global</h5>
                <p class="small text-secondary">Mitra resmi Universitas Terbuka dalam menyelenggarakan pendidikan jarak jauh yang berkualitas dan terjangkau.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Tautan Cepat</h5>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-secondary text-decoration-none">Beranda</a></li>
                    <li><a href="#about" class="text-secondary text-decoration-none">Tentang Kami</a></li>
                    <li><a href="#fakultas" class="text-secondary text-decoration-none">Fakultas</a></li>
                    <li><a href="#services" class="text-secondary text-decoration-none">Layanan</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Pendidikan No. 123, Kota Besar</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@salutindoglobal.com</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i> (021) 1234-5678</li>
                </ul>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center small text-secondary">
            &copy; {{ date('Y') }} SALUT Indo Global. All rights reserved.
        </div>
    </div>
</footer>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .ls-wide {
        letter-spacing: 2px;
    }
</style>
@endsection
