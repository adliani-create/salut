@extends('layouts.app')

@section('content')
<!-- Navbar is handled by layouts.app, ensuring sticky behavior and standard links -->

<!-- Hero Section -->
<section class="hero-section text-white text-center d-flex align-items-center" style="background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(0, 0, 0, 0.6)), url('https://source.unsplash.com/1600x900/?university,student'); background-size: cover; background-position: center; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Kuliah Fleksibel Dengan Biaya Terjangkau</h1>
                <p class="lead mb-5 animate__animated animate__fadeInUp">Bergabunglah dengan SALUT Indo Global.Kami menghadirkan akses pendidikan tinggi negeri terbaik dari Universitas Terbuka dengan standar layanan prima. Dapatkan kesempatan belajar di Perguruan Tinggi Negeri (PTN) bergengsi dengan skema biaya yang sangat efisien.</p>
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
                <p class="lead text-secondary mb-4"> SALUT (Sentra Layanan Universitas Terbuka Indo Global) merupakan kepanjangan tangan teknis operasional dari UT Daerah setempat yang menjadi tempat layanan administrasi akademik dan kegiatan akademik serta kegiatan lainnya yang berlokasi di kabupaten atau kota, sehingga jarak akses mahasiswa dan pemangku kepentingan lainnya dengan kantor layanan UT semakin dekat.</p>
                <p>Kenapa memilih kami?</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Mempermudah Akses Layanan</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Dukungan Akademik</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Fasilitas Pendukung</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Pendampingan dan Motivasi</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Kegiatan Kemahasiswaan</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Kelebihan Eksklusif Section -->
<section id="advantages" class="py-5 text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);">
    <div class="container py-4">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <div class="mb-4">
                    <i class="bi bi-award-fill display-3 text-warning mb-3"></i>
                </div>
                <h2 class="display-6 fw-bold mb-4">Kelebihan Eksklusif SALUT Indo Global</h2>
                <p class="lead mb-0 opacity-100 fw-normal">SALUT Indo Global memiliki berbagai program pelatihan non-akademik dan terintegrasi dengan lembaga training serta perusahaan rekanan yang siap mendukung karir Anda sebagai mahasiswa Universitas Terbuka.</p>
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
<!-- Fakultas Ekonomi dan Bisnis -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mb-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-graph-up fs-3"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Fakultas Ekonomi dan Bisnis</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-primary"></i> Manajemen</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-primary"></i> Ekonomi Pembangunan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-primary"></i> Ekonomi Syariah</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-primary"></i> Akuntansi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-primary"></i> Akuntansi Keuangan Publik</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-primary"></i> Pariwisata</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fakultas Sains dan Teknologi -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle mb-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-cpu fs-3"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Fakultas Sains dan Teknologi</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Statistika</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Matematika</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Biologi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Teknologi Pangan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Agribisnis</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Perencanaan Wilayah dan Kota</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Sistem Informasi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-success"></i> Sains Data</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sekolah Pascasarjana -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="icon-box bg-dark bg-opacity-10 text-dark rounded-circle mb-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-mortarboard-fill fs-3"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Sekolah Pascasarjana</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Studi Lingkungan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Manajemen Perikanan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Administrasi Publik</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Manajemen</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Pendidikan Dasar</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Pendidikan Matematika</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Pendidikan Bahasa Inggris</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Pendidikan Anak Usia Dini</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Magister Hukum</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Doktor Ilmu Manajemen</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-dark"></i> Doktor Ilmu Administrasi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fakultas Keguruan dan Ilmu Pendidikan -->
            <div class="col-md-6 col-lg-4 justify-content-center">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle mb-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-book fs-3"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Fakultas Keguruan dan Ilmu Pendidikan</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Bahasa & Sastra Ind.</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Bahasa Inggris</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Biologi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Fisika</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Kimia</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Matematika</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Ekonomi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Pendidikan Pancasila & KN</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> Teknologi Pendidikan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> PGSD & PGPAUD</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-warning"></i> PPG & PAI</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Fakultas Hukum Ilmu Sosial dan Ilmu Politik -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-body p-4">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-circle mb-4 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="bi bi-bank fs-3"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Fakultas Hukum Ilmu Sosial dan Ilmu Politik</h4>
                        <ul class="list-unstyled text-secondary small">
                             <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Kearsipan (D4)</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Perpajakan (D3 & S1)</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Administrasi Bisnis</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Hukum</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Ilmu Pemerintahan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Ilmu Komunikasi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Ilmu Perpustakaan</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Sosiologi</li>
                            <li class="mb-1"><i class="bi bi-chevron-right me-2 text-danger"></i> Sastra Inggris</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program Pilihan Section -->
<section id="program-pilihan" class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase">Pengembangan Skill</h6>
            <h2 class="display-5 fw-bold">Program Pilihan</h2>
            <p class="text-secondary w-75 mx-auto">Ini adalah program pelatihan non-akademik yang akan didapatkan oleh mahasiswa yang mendaftar di Universitas Terbuka SALUT Indo Global. Setiap bulan akan ada minimal 1 pelatihan, baik offline maupun online, secara GRATIS.</p>
        </div>

        <div class="row g-4">
            <!-- Public Speaking & Komunikasi -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card bg-white">
                    <div class="card-body p-4">
                        <div class="mb-4 text-primary">
                            <i class="bi bi-mic display-4"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Public Speaking & Komunikasi</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-primary"></i> General Public Speaking</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-primary"></i> Percaya Diri Dalam 7 Hari</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-primary"></i> Master Of Ceremony</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-primary"></i> Pelatihan Speak To Win</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-primary"></i> Pelatihan Membuat Slide Presentasi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Digital Marketing -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card bg-white">
                    <div class="card-body p-4">
                        <div class="mb-4 text-danger">
                            <i class="bi bi-graph-up-arrow display-4"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Digital Marketing</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-danger"></i> Dropship</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-danger"></i> Shopee & Tiktok Affiliate</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-danger"></i> Content Creator</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-danger"></i> Admin Marketplace</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-danger"></i> Live Selling</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kuliah Plus Wirausaha -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card bg-white">
                    <div class="card-body p-4">
                        <div class="mb-4 text-success">
                            <i class="bi bi-briefcase display-4"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Kuliah Plus Wirausaha</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-success"></i> Passion To Profit</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-success"></i> Extremely Productivity</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-success"></i> Personality Branding</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-success"></i> Grand Strategic Business Plan</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-success"></i> Pitch Deck</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Teknologi Informasi -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card bg-white">
                    <div class="card-body p-4">
                        <div class="mb-4 text-info">
                            <i class="bi bi-laptop display-4"></i>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Teknologi Informasi</h4>
                        <ul class="list-unstyled text-secondary small">
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-info"></i> UI UX Designer</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-info"></i> Front End Development</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-info"></i> Back End Development</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-info"></i> Database Engineer</li>
                            <li class="mb-2"><i class="bi bi-check-circle me-2 text-info"></i> Freelancer Programmer</li>
                        </ul>
                    </div>
                </div>
            </div>
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
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Kuliah Plus Magang Kerja, Skill Academy, Affiliator/Creator, atau Wirausaha</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Kuliah Plus Skill Academy</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Kuliah Plus Affiliator/Creator</li>
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Kuliah Plus Wirausaha</li>
                        </ul>
                        <a href="#" class="btn btn-light btn-sm mt-4">Lihat Detail</a>
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
                    <li><a href="#program" class="text-secondary text-decoration-none">Program Pilihan</a></li>
                    <li><a href="#services" class="text-secondary text-decoration-none">Layanan</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Siliwangi No. 54, Kahuripan, Kec Tawang, Kota Tasikmalaya, Jawa Barat, 46115, Indonesia</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i> salutindoglobal@gmail.com</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i> +62 851-3501-1213</li>
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
