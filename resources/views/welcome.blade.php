@extends('layouts.app')

@section('content')
<!-- Navbar is handled by layouts.app, ensuring sticky behavior and standard links -->

<!-- Hero Section -->
<!-- Hero Section -->
<section class="hero-section text-white text-center d-flex align-items-center" style="background: linear-gradient(rgba(13, 110, 253, 0.8), rgba(0, 0, 0, 0.6)), url('{{ $setting->banner_path ? Storage::url($setting->banner_path) : 'https://source.unsplash.com/1600x900/?university,student' }}'); background-size: cover; background-position: center; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">{{ $setting->hero_title }}</h1>
                <p class="lead mb-5 animate__animated animate__fadeInUp">{{ $setting->hero_subtitle ?? 'Bergabunglah dengan SALUT Indo Global.Kami menghadirkan akses pendidikan tinggi negeri terbaik dari Universitas Terbuka dengan standar layanan prima. Dapatkan kesempatan belajar di Perguruan Tinggi Negeri (PTN) bergengsi dengan skema biaya yang sangat efisien.' }}</p>
                <div class="animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary fw-bold me-3 px-4 rounded-pill">Daftar Sekarang</a>
                    <a href="#about" class="btn btn-outline-light btn-lg px-4 rounded-pill">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kabar Kampus (News) Section -->
@php
    $newsItems = $latestNews->count() > 0 ? $latestNews : collect([
        (object)[
            'title' => 'Selamat Datang di Website Baru SALUT Indo Global',
            'slug' => '#',
            'thumbnail' => null,
            'published_at' => now(),
            'content' => 'Ini adalah contoh berita pertama. Silakan tambahkan berita melalui halaman admin untuk mengganti konten ini.'
        ],
        (object)[
            'title' => 'Penerimaan Mahasiswa Baru Tahun Ajaran 2026/2027',
            'slug' => '#',
            'thumbnail' => null,
            'published_at' => now()->subDays(2),
            'content' => 'Segera daftarkan diri Anda untuk menjadi bagian dari civitas akademika Universitas Terbuka.'
        ],
        (object)[
            'title' => 'Jadwal Pelatihan Public Speaking Batch 5',
            'slug' => '#',
            'thumbnail' => null,
            'published_at' => now()->subDays(5),
            'content' => 'Pelatihan soft skills untuk mahasiswa akan diadakan minggu depan. Jangan lewatkan kesempatan ini.'
        ]
    ]);
@endphp

<section id="news" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-wide mb-2">Berita & Pengumuman</h6>
            <h2 class="display-5 fw-bold text-dark">Kabar Terbaru</h2>
            <div class="mx-auto bg-primary mt-3" style="width: 80px; height: 4px; border-radius: 2px;"></div>
        </div>
        
        <div class="row g-4">
            @foreach($newsItems as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden rounded-3 position-relative">
                    <!-- Thumbnail with Date Badge -->
                    <div class="position-relative overflow-hidden">
                        <img src="{{ $item->thumbnail ? Storage::url($item->thumbnail) : 'https://source.unsplash.com/800x600/?education' }}" 
                             class="card-img-top object-fit-cover transition-scale" 
                             alt="{{ $item->title }}" 
                             style="height: 240px; width: 100%;">
                        
                        <div class="position-absolute top-0 end-0 m-3">
                            <div class="bg-primary text-white rounded-3 py-1 px-3 shadow-sm text-center">
                                <span class="d-block fw-bold fs-5 lh-1">{{ $item->published_at->format('d') }}</span>
                                <span class="d-block small text-uppercase">{{ $item->published_at->format('M') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                             <span class="badge bg-light text-primary border border-primary-subtle rounded-pill px-3 py-2 fw-normal">Berita Utama</span>
                        </div>
                        
                        <h5 class="card-title fw-bold text-dark mb-3 lh-sm">
                            <a href="{{ route('public.news.show', $item->slug) }}" class="text-decoration-none text-dark stretched-link">
                                {{ Str::limit($item->title, 60) }}
                            </a>
                        </h5>
                        
                        <p class="card-text text-secondary mb-4 flex-grow-1 line-clamp-3">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                        
                        <div class="mt-auto border-top pt-3 d-flex align-items-center justify-content-between">
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ $item->published_at->diffForHumans() }}</small>
                            <span class="text-primary fw-semibold small">Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-primary btn-lg rounded-pill px-5 fw-bold hover-scale">
                Lihat Semua Berita <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


<!-- About Section -->
<section id="about" class="py-5">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                @if($setting->about_image)
                    <img src="{{ Storage::url($setting->about_image) }}" alt="About" class="img-fluid rounded-3 shadow-lg">
                @else
                    <img src="https://source.unsplash.com/800x600/?office,meeting" alt="About Default" class="img-fluid rounded-3 shadow-lg">
                @endif
            </div>
            <div class="col-md-6 ps-md-5">
                <h6 class="text-primary fw-bold text-uppercase ls-wide">Tentang Kami</h6>
                <h2 class="display-5 fw-bold mb-4">{{ $setting->about_title ?? 'SALUT Indo Global' }}</h2>
                <div class="lead text-secondary mb-4">
                    {!! $setting->about_content ?? '<p>SALUT (Sentra Layanan Universitas Terbuka Indo Global)... (Default Text)</p>' !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kelebihan Eksklusif Section -->
<section id="advantages" class="py-5 text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h2 class="display-6 fw-bold mb-4">Kelebihan Eksklusif SALUT Indo Global</h2>
        </div>
        
        @if(isset($advantages) && $advantages->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($advantages as $item)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 bg-white bg-opacity-10 border-0 shadow-sm text-white text-center p-4 hover-lift">
                        <div class="mb-3">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" alt="Icon" class="img-fluid mb-2" style="max-height: 60px;">
                            @else
                                <i class="bi bi-check-circle-fill fs-1 text-warning"></i>
                            @endif
                        </div>
                        <h5 class="fw-bold">{{ $item->title }}</h5>
                        <p class="small opacity-75 mb-0">{{ $item->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Default Static Content if no data -->
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <div class="mb-4">
                        <i class="bi bi-award-fill display-3 text-warning mb-3"></i>
                    </div>
                    <p class="lead mb-0 opacity-100 fw-normal">SALUT Indo Global memiliki berbagai program pelatihan non-akademik dan terintegrasi dengan lembaga training serta perusahaan rekanan yang siap mendukung karir Anda sebagai mahasiswa Universitas Terbuka.</p>
                </div>
            </div>
        @endif
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
            @if(isset($studies) && $studies->count() > 0)
                @foreach($studies as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle mb-4 d-flex align-items-center justify-content-center overflow-hidden" style="width: 60px; height: 60px;">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="Icon" class="w-100 h-100 object-fit-cover">
                                @else
                                    <i class="bi bi-book fs-3"></i>
                                @endif
                            </div>
                            <h4 class="card-title fw-bold mb-3">{{ $item->title }}</h4>
                            <div class="text-secondary small">
                                {!! nl2br(e($item->description)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
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
            @endif
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
                            <li class="mb-2"><i class="bi bi-check2 me-2"></i> Kuliah Plus Magang Kerja</li>
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
<footer class="bg-dark text-white pt-5 pb-4" style="background-color: #1a1e21 !important;">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <!-- Brand & Social -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo-salut.png') }}" alt="Logo" height="40" class="me-2 bg-white rounded p-1">
                    <h5 class="fw-bold mb-0 text-white">SALUT Indo Global</h5>
                </div>
                <p class="text-secondary small mb-4 lh-lg">
                    {{ $setting->footer_description ?? 'Mitra resmi Universitas Terbuka dalam menyelenggarakan pendidikan jarak jauh yang berkualitas, fleksibel, dan terjangkau untuk semua kalangan.' }}
                </p>
                
                <h6 class="text-uppercase fw-bold small text-white-50 mb-3 ls-wide">Ikuti Kami</h6>
                <div class="d-flex gap-3 social-links">
                    @if($setting->instagram_url)
                    <a href="{{ $setting->instagram_url }}" target="_blank" class="social-btn instagram" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    @endif
                    @if($setting->tiktok_url)
                    <a href="{{ $setting->tiktok_url }}" target="_blank" class="social-btn tiktok" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Tautan Cepat -->
            <div class="col-lg-2 col-md-6 mb-4 mb-md-0">
                <h6 class="fw-bold mb-3 text-white">Tautan Cepat</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white transition">Beranda</a></li>
                    <li class="mb-2"><a href="#about" class="text-secondary text-decoration-none hover-white transition">Tentang Kami</a></li>
                    <li class="mb-2"><a href="#fakultas" class="text-secondary text-decoration-none hover-white transition">Fakultas</a></li>
                    <li class="mb-2"><a href="#news" class="text-secondary text-decoration-none hover-white transition">Berita</a></li>
                </ul>
            </div>
            <!-- Kontak -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3 text-white">Hubungi Kami</h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-3 d-flex">
                        <i class="bi bi-geo-alt me-3 text-primary mt-1"></i>
                        <div>
                            <span>{{ $setting->address ?? 'Jl. Siliwangi No. 54, Kahuripan, Kec. Tawang, Kota Tasikmalaya, Jawa Barat, 46115' }}</span>
                            @if($setting->google_maps_link)
                                <div class="mt-2">
                                    <a href="{{ $setting->google_maps_link }}" target="_blank" class="text-primary text-decoration-none small">
                                        <i class="bi bi-map me-1"></i>Lihat di Peta
                                    </a>
                                </div>
                            @endif
                        </div>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope me-3 text-primary"></i>
                        <span>{{ $setting->email ?? 'salutindoglobal@gmail.com' }}</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-whatsapp me-3 text-primary"></i>
                        <span>{{ $setting->phone ?? '+62 851-3501-1213' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary opacity-25 my-4">
        
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <small class="text-secondary">&copy; {{ date('Y') }} SALUT Indo Global. All rights reserved.</small>
            </div>
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

<!-- Floating WhatsApp Button -->
@php
    $waNumber = $setting->whatsapp ?? $homeSetting->whatsapp ?? '6281234567890';
    // Ensure format is correct for URL (remove non-digits, ensuring it starts with country code if needed, but assuming input is 628...)
    $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
@endphp
<a href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn-whatsapp shadow-lg" title="Chat dengan Kami">
    <i class="bi bi-whatsapp"></i>
</a>

<style>
    .btn-whatsapp {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background-color: #25D366;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        z-index: 1000;
        transition: all 0.3s ease;
        text-decoration: none;
        animation: pulse-green 2s infinite;
    }

    .btn-whatsapp:hover {
        background-color: #128C7E;
        color: white;
        transform: scale(1.1);
    }

    @keyframes pulse-green {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
        }
        70% {
            box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
        }
    }
</style>
@endsection
