@extends('layouts.student')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white overflow-hidden rounded-4 position-relative">
                <div class="card-body p-5 position-relative z-1">
                    <h2 class="fw-bold">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="lead mb-0">Here's your academic and activity overview.</p>
                </div>
                <!-- Abstract Background Shapes -->
                <div class="position-absolute end-0 top-0 h-100 w-50" style="background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1)); clip-path: polygon(20% 0%, 100% 0, 100% 100%, 0% 100%);"></div>
            </div>
        </div>
    </div>

    <!-- Student Details -->
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    <small class="text-muted d-block fw-bold text-uppercase">NIM</small>
                    <span class="fs-5 fw-bold text-dark">{{ Auth::user()->nim ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-0">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    <small class="text-muted d-block fw-bold text-uppercase">Fakultas</small>
                    <span class="fs-5 fw-bold text-dark">{{ Auth::user()->faculty ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                    <small class="text-muted d-block fw-bold text-uppercase">Jurusan</small>
                    <span class="fs-5 fw-bold text-dark">{{ Auth::user()->major ?? '-' }}</span>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body text-center">
                     <small class="text-muted d-block fw-bold text-uppercase">Semester</small>
                    <span class="fs-5 fw-bold text-primary">{{ Auth::user()->semester ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Admission Receipt Banner -->
    @if(Auth::user()->status === 'active')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-success shadow-sm rounded-4 overflow-hidden" style="border-width: 2px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-column flex-md-row bg-light">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-file-earmark-pdf-fill text-success fs-2"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Bukti Pembayaran Admisi Berhasil diverifikasi</h5>
                            <p class="text-muted small mb-0">Klik tombol di samping untuk mengunduh bukti lunas admisi Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('student.admission.receipt') }}" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm px-4">
                        <i class="bi bi-download me-2"></i> Unduh Kuitansi
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Overview Widgets -->
    <div class="row g-4 mb-4">
        <!-- Billing Widget -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                     <div class="position-absolute end-0 top-0 p-4 opacity-10">
                         <i class="bi bi-wallet2" style="font-size: 5rem; color: #dc3545;"></i>
                    </div>
                    
                    <h5 class="fw-bold text-muted mb-3 small text-uppercase">Tagihan Pembayaran</h5>
                    
                    <div class="display-6 fw-bold {{ $totalUnpaid > 0 ? 'text-danger' : 'text-success' }} mb-2">
                        Rp {{ number_format($totalUnpaid, 0, ',', '.') }}
                    </div>

                    @if($totalUnpaid > 0)
                        <div class="badge bg-danger bg-opacity-10 text-danger mb-3 px-3 py-2 rounded-pill">
                            <i class="bi bi-exclamation-circle me-1"></i> Belum Lunas
                        </div>
                        <a href="{{ route('student.billing.index') }}" class="btn btn-danger rounded-pill fw-bold w-100">
                            Bayar Sekarang <i class="bi bi-arrow-right-short"></i>
                        </a>
                    @else
                        <div class="badge bg-success bg-opacity-10 text-success mb-3 px-3 py-2 rounded-pill">
                            <i class="bi bi-check-circle me-1"></i> Lunas
                        </div>
                        <button class="btn btn-light text-muted w-100 rounded-pill" disabled>Tidak ada tagihan</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Training Widget -->
        <div class="col-md-6">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-primary">Jadwal Pelatihan</h5>
                    <small><a href="{{ route('student.non-academic') }}" class="text-decoration-none fw-bold">Lihat Semua</a></small>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($trainings as $training)
                        <li class="list-group-item border-0 px-4 py-3 d-flex align-items-center">
                            <div class="me-3 text-center bg-light rounded p-2" style="min-width: 55px;">
                                <span class="d-block fw-bold text-primary">{{ \Carbon\Carbon::parse($training->date)->format('d') }}</span>
                                <span class="d-block small text-muted lh-1">{{ \Carbon\Carbon::parse($training->date)->format('M') }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $training->title }}</h6>
                                <div class="small text-muted">
                                    <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($training->time)->format('H:i') }} WIB
                                </div>
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item border-0 text-center py-4 text-muted">
                            <small>Belum ada jadwal pelatihan.</small>
                        </li>
                        @endforelse
                    </ul>
                </div>
             </div>
        </div>
    </div>


</div>
@endsection
