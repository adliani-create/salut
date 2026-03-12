@extends('layouts.student')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white overflow-hidden rounded-4 position-relative">
                <div class="card-body p-4 p-md-5 position-relative z-1">
                    <h2 class="fw-bold mb-1">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="lead mb-0 opacity-75 fs-6">Here's your academic and activity overview.</p>
                </div>
                <!-- Abstract Background Shapes -->
                <div class="position-absolute end-0 top-0 h-100 w-50" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1)); clip-path: polygon(20% 0%, 100% 0, 100% 100%, 0% 100%);"></div>
            </div>
        </div>
    </div>

    <!-- Student Summary Widget -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-6 col-md-3 border-end border-bottom border-md-bottom-0">
                            <div class="p-4 bg-light text-center h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-person-badge text-primary fs-3 mb-2"></i>
                                <span class="d-block text-muted small text-uppercase fw-bold mb-1">NIM</span>
                                <span class="d-block fw-bold text-dark fs-5">{{ Auth::user()->nim ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 border-end border-bottom border-md-bottom-0">
                            <div class="p-4 bg-light text-center h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-building text-primary fs-3 mb-2"></i>
                                <span class="d-block text-muted small text-uppercase fw-bold mb-1">Fakultas</span>
                                <span class="d-block fw-bold text-dark text-truncate" title="{{ Auth::user()->faculty ?? '-' }}">{{ Auth::user()->faculty ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 border-end">
                            <div class="p-4 bg-light text-center h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-book text-primary fs-3 mb-2"></i>
                                <span class="d-block text-muted small text-uppercase fw-bold mb-1">Jurusan (Prodi)</span>
                                <span class="d-block fw-bold text-dark text-truncate" title="{{ Auth::user()->major ?? '-' }}">{{ Auth::user()->major ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-4 bg-light text-center h-100 d-flex flex-column justify-content-center">
                                <i class="bi bi-mortarboard text-primary fs-3 mb-2"></i>
                                <span class="d-block text-muted small text-uppercase fw-bold mb-1">Semester</span>
                                <span class="d-block fw-bold text-dark fs-5">{{ Auth::user()->semester ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- H-1 Deadline Notifications -->
    @if(isset($upcomingDeadlines) && $upcomingDeadlines->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger shadow-sm border-0 rounded-4 d-flex align-items-center mb-0" role="alert">
                <div class="bg-danger text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-bell-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Pengingat Penting (H-1)</h6>
                    <p class="mb-0 small">
                        Anda memiliki <strong>{{ $upcomingDeadlines->count() }}</strong> agenda akademik dengan tenggat waktu hari ini atau besok. 
                        Silakan periksa panel Agenda Terdekat di bawah.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="row g-4 mb-4">
        <!-- Full Width: Academic Overview & Widgets -->
        <div class="col-lg-12">

    <!-- Academic Documents Widget / Layanan Administrasi -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-folder2-open me-2 text-primary"></i> Layanan Administrasi / Dokumen</h5>
        </div>
        
        <!-- KTM Card -->
        <div class="col-md-12 mb-3">
            <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden">
                <div class="card-body p-4 d-flex flex-column flex-md-row align-items-center justify-content-between position-relative">
                    <div class="position-absolute end-0 top-0 p-4 opacity-10" style="z-index: 0;">
                        <i class="bi bi-person-vcard text-primary" style="font-size: 5rem;"></i>
                    </div>
                    <div class="position-relative z-1 d-flex flex-column mb-3 mb-md-0">
                        <h5 class="fw-bold text-dark mb-2">Kartu Tanda Mahasiswa (KTM)</h5>
                        <p class="text-muted small mb-0">Kartu identitas resmi sebagai mahasiswa aktif SALUT Indo Global. Harap simpan dan gunakan saat diperlukan.</p>
                    </div>
                    <div class="position-relative z-1">
                        <a href="{{ route('student.documents.ktm') }}" class="btn btn-primary rounded-pill fw-bold shadow-sm px-4">
                            <i class="bi bi-download me-1"></i> Unduh KTM
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admission Receipt Banner -->
        @if($showAdmissionReceiptToast)
        <div class="col-12 mt-2">
            <div class="alert alert-success alert-dismissible fade show border-success shadow-sm rounded-4 overflow-hidden mb-0" role="alert" style="border-width: 2px;">
                <div class="d-flex align-items-center justify-content-between flex-column flex-md-row bg-light p-2">
                    <div class="d-flex align-items-center mb-0">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-file-earmark-pdf-fill text-success fs-4 d-block"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Bukti Penerimaan Admisi Berhasil diverifikasi</h6>
                            <p class="text-muted small mb-0">Klik tombol di samping untuk mengunduh bukti lunas admisi. Pesan ini hanya muncul satu kali.</p>
                        </div>
                    </div>
                    <a href="{{ route('student.admission.receipt') }}" class="btn btn-success btn-sm rounded-pill fw-bold shadow-sm px-4 mt-3 mt-md-0 me-4">
                        <i class="bi bi-download me-2"></i> Unduh Kuitansi
                    </a>
                </div>
                <button type="button" class="btn-close mt-2 me-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- Small Widgets Row -->
    <div class="row g-4 mb-5">
        <!-- Tagihan (Unpaid Bills) Widget -->
        <div class="col-md-4">
            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-wallet2 me-2 text-primary"></i> Info Tagihan</h6>
            @if($totalUnpaid > 0)
                <div class="card border-0 shadow-sm rounded-4 bg-danger bg-opacity-10 h-100">
                    <div class="card-body p-3 d-flex flex-column justify-content-center text-center">
                        <div class="bg-danger text-white rounded-circle p-2 mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-danger mb-1" style="font-size: 0.95rem;">Belum Lunas</h6>
                        <p class="text-danger opacity-75 small mb-3">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                        <a href="{{ route('student.billing.index') }}" class="btn btn-danger btn-sm rounded-pill fw-bold px-4 mt-auto">Bayar Sekarang</a>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4 bg-light h-100">
                    <div class="card-body p-3 d-flex flex-column justify-content-center text-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-check-circle-fill fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-success mb-1" style="font-size: 0.95rem;">Tidak Ada Tagihan</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.75rem;">Semua administrasi beres.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Jadwal Pelatihan Widget -->
        <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i> Pelatihan</h6>
                <a href="{{ route('student.training') }}" class="small text-primary text-decoration-none">Lihat Semua</a>
            </div>
            <div class="d-flex flex-column gap-2 h-100">
                @forelse($trainings->take(3) as $training)
                    @php
                        $bgColor = 'primary';
                        if($loop->iteration % 3 == 0) $bgColor = 'success';
                        else if($loop->iteration % 2 == 0) $bgColor = 'warning text-dark';
                    @endphp
                    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                        <div class="d-flex">
                            <div class="bg-{{ $bgColor }} text-white text-center p-2 d-flex flex-column justify-content-center align-items-center" style="width: 55px; min-width: 55px;">
                                <span class="fs-5 fw-bold lh-1">{{ \Carbon\Carbon::parse($training->start_date)->format('d') }}</span>
                                <span class="text-uppercase" style="font-size: 0.65rem;">{{ \Carbon\Carbon::parse($training->start_date)->format('M') }}</span>
                            </div>
                            <div class="card-body p-2 d-flex flex-column justify-content-center">
                                <span class="fw-bold text-truncate d-block text-dark" style="font-size: 0.85rem;" title="{{ $training->title }}">{{ $training->title }}</span>
                                <div class="text-muted mt-1" style="font-size: 0.7rem;">
                                    <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($training->start_time)->format('H:i') }} | {{ $training->platform ?? 'Online' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 bg-light rounded-4 h-100 d-flex flex-column justify-content-center">
                        <i class="bi bi-calendar-x text-muted fs-3 mb-2"></i>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem;">Belum ada pelatihan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Jadwal Akademik Widget -->
        <div class="col-md-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-dark mb-0"><i class="bi bi-journal-text me-2 text-primary"></i> Akademik</h6>
                <a href="{{ route('student.schedules') }}" class="small text-primary text-decoration-none">Selengkapnya</a>
            </div>
            <div class="d-flex flex-column gap-2 h-100">
                @forelse($academicSchedules->take(3) as $schedule)
                    @php
                        $badgeColor = 'secondary';
                        if($schedule->type == 'tugas') $badgeColor = 'danger';
                        if($schedule->type == 'diskusi') $badgeColor = 'warning text-dark';
                        if($schedule->type == 'tuweb') $badgeColor = 'primary';
                        if($schedule->type == 'ujian') $badgeColor = 'danger';
                    @endphp
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body p-2 px-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-{{ $badgeColor }} text-uppercase px-2 rounded-pill" style="font-size: 0.6rem;">
                                    {{ $schedule->type }}
                                </span>
                                <span class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</span>
                            </div>
                            <span class="fw-bold text-dark d-block text-truncate mb-1" style="font-size: 0.85rem;">{{ $schedule->title }}</span>
                            <div class="d-flex justify-content-between text-muted" style="font-size: 0.7rem;">
                                <span>{{ $schedule->date->format('d M y') }}</span>
                                @if($schedule->deadline)
                                    <span class="text-danger fw-bold" title="Tenggat"><i class="bi bi-exclamation-circle me-1"></i>{{ $schedule->deadline->format('d M y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 bg-light rounded-4 h-100 d-flex flex-column justify-content-center">
                        <i class="bi bi-calendar-check fs-3 mb-2 text-opacity-50 text-success"></i>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem;">Tidak ada jadwal terdekat.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>


</div>
@endsection
