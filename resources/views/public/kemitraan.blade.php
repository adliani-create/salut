@extends('layouts.app')

@section('content')
    <div class="bg-primary text-white py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Tumbuh Bersama Kami Sebagai Mitra SALUT</h1>
                    <p class="lead mb-4 text-white-50">Bergabunglah dengan jaringan Mitra SALUT dan jadilah bagian dari
                        transformasi pendidikan jarak jauh. Dapatkan berbagai keuntungan menarik dan peluang bisnis yang
                        menjanjikan.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register.mitra') }}"
                            class="btn btn-warning btn-lg fw-bold px-4 rounded-pill">Daftar Sekarang <i
                                class="bi bi-arrow-right ms-2"></i></a>
                        <a href="#benefits" class="btn btn-outline-light btn-lg px-4 rounded-pill">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-end">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800"
                        alt="Mitra SALUT" class="img-fluid rounded-4 shadow-lg"
                        style="max-height: 400px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5" id="benefits">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase tracking-wide">Keuntungan Mitra</h6>
            <h2 class="fw-bold text-dark">Mengapa Bergabung dengan SALUT?</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Kami memberikan dukungan penuh agar Anda dapat
                berkembang dan memberikan layanan terbaik kepada calon mahasiswa di daerah Anda.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 py-3 px-4 mb-5">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                    <h5 class="mb-0 text-success">{{ session('success') }}</h5>
                </div>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 text-center p-4 hover-lift active">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-4"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-currency-dollar fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Komisi Menarik</h4>
                    <p class="text-muted">Dapatkan komisi yang kompetitif dari setiap mahasiswa baru yang Anda bantu
                        daftarkan melalui program afiliasi kami.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 text-center p-4 hover-lift">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-4"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-laptop fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Sistem Terintegrasi</h4>
                    <p class="text-muted">Akses ke dashboard khusus Mitra untuk memantau pendaftar, pendapatan komisi, dan
                        materi promosi secara real-time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 text-center p-4 hover-lift">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-4"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-people fw-bold fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Dukungan Penuh</h4>
                    <p class="text-muted">Tim kami siap memberikan dukungan teknis dan operasional untuk memastikan
                        kelancaran aktivitas kemitraan Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light py-5">
        <div class="container py-4">
            <div class="row bg-white rounded-5 shadow-sm overflow-hidden border">
                <div class="col-lg-6 p-5">
                    <h3 class="fw-bold mb-4">Langkah Menjadi Mitra</h3>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                style="width: 40px; height: 40px;">1</div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">Isi Formulir Pendaftaran</h5>
                            <p class="text-muted">Lengkapi data diri dan PIC di halaman pendaftaran mitra.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                style="width: 40px; height: 40px;">2</div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">Verifikasi Data</h5>
                            <p class="text-muted">Tim Admin kami akan mereview pengajuan Anda dalam 1-2 hari kerja.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                style="width: 40px; height: 40px;">3</div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">Approval & Kode Referral</h5>
                            <p class="text-muted">Setelah disetujui, Anda akan mendapatkan Kode Referral eksklusif.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                style="width: 40px; height: 40px;">4</div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="fw-bold">Mulai Jangkau Calon Mahasiswa</h5>
                            <p class="text-muted">Sebarkan kode referral Anda dan kelola jaringan affiliator (jika
                                diperlukan).</p>
                        </div>
                    </div>
                </div>
                <div
                    class="col-lg-6 bg-primary text-white p-5 d-flex flex-column justify-content-center align-items-center text-center">
                    <i class="bi bi-briefcase display-1 mb-3 opacity-50"></i>
                    <h3 class="fw-bold">Siap Bergabung?</h3>
                    <p class="mb-4 text-white-50">Ambil langkah pertama untuk kolaborasi yang menguntungkan. Daftarkan diri
                        Anda atau institusi Anda sekarang juga.</p>
                    <a href="{{ route('register.mitra') }}"
                        class="btn btn-light btn-lg text-primary fw-bold px-5 rounded-pill shadow-sm">Daftar Mitra SALUT</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05) !important;
        }

        .tracking-wide {
            letter-spacing: 0.1em;
        }
    </style>
@endsection