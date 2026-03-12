@extends('layouts.affiliator')

@section('title', 'Dashboard Affiliator')

@section('content')

<!-- Recent Transfer Notifications -->
@if(isset($recentTransfers) && $recentTransfers->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            @foreach($recentTransfers as $transfer)
            <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-2 alert-dismissible fade show" role="alert">
                <div class="bg-success text-white rounded-circle p-2 me-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                    <i class="bi bi-cash-coin fs-4"></i>
                </div>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Pencairan Transfer Berhasil!</h6>
                    <p class="mb-0 small">
                        Dana sebesar <strong>Rp {{ number_format($transfer->amount, 0, ',', '.') }}</strong> 
                        telah berhasil ditransfer oleh Admin ke rekening <strong>{{ $transfer->bank_name }}</strong> Anda pada {{ $transfer->updated_at->format('d M Y, H:i') }}.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Referral Copy Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white border-0 shadow-sm rounded-4 overflow-hidden position-relative">
            <!-- Background Decoration -->
            <div class="position-absolute end-0 top-0 h-100 text-white opacity-10" style="margin-right: -20px; margin-top: -20px; pointer-events: none; z-index: 0;">
                <i class="bi bi-briefcase-fill d-none d-md-block" style="font-size: 15rem;"></i>
                <i class="bi bi-briefcase-fill d-block d-md-none" style="font-size: 8rem; margin-top: 1rem;"></i>
            </div>
            
            <div class="card-body p-4 p-md-5 position-relative" style="z-index: 1;">
                <div class="row align-items-center">
                    <div class="col-md-7 mb-4 mb-md-0">
                        <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Penambahan Mahasiswa</span>
                        <h3 class="fw-bold mb-3">Mulai Merekrut Mahasiswa Baru</h3>
                        <p class="mb-0 text-white-50 fs-5">Bagikan link ini ke calon mahasiswa. Setiap mahasiswa yang mendaftar dan <strong class="text-white">disetujui (bayar)</strong> otomatis memberikan Anda komisi.</p>
                        
                        <div class="mt-4">
                            <a href="{{ route('affiliator.students.create') }}" class="btn btn-light btn-lg text-primary fw-bold rounded-pill px-4 me-2 shadow-sm">
                                <i class="bi bi-person-plus-fill me-2"></i> Input Mahasiswa Manual
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="bg-dark bg-opacity-25 rounded-4 p-4 border border-white border-opacity-25 shadow">
                            <label class="small text-white-50 text-uppercase mb-2 fw-bold d-block"><i class="bi bi-link-45deg fs-5 me-1 align-middle"></i> Link Referral Anda</label>
                            <div class="input-group input-group-lg border border-2 border-white border-opacity-50 rounded-3 overflow-hidden">
                                <span class="input-group-text bg-white border-0 text-primary fw-bold px-3"><i class="bi bi-globe"></i></span>
                                <input type="text" id="referralLinkInput" class="form-control bg-white text-dark fw-bold border-0 fs-6 ps-2" value="{{ $referralLink }}" readonly>
                                <button class="btn btn-warning fw-bold px-3 px-md-4 text-dark" type="button" onclick="copyReferralLink(this)">
                                    <i class="bi bi-copy me-1"></i><span class="d-none d-md-inline"> Salin</span>
                                </button>
                            </div>
                            <div class="text-center mt-3">
                                <div class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill font-monospace" style="letter-spacing: 1px;">
                                    KODE: {{ Auth::user()->referral_code }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Metrics & KPI -->
<div class="row g-4 mb-4">
    <!-- Poin Komisi -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-success bg-opacity-10">
            <div class="position-absolute end-0 bottom-0 opacity-25 p-3">
                <i class="bi bi-wallet2 display-3 text-success"></i>
            </div>
            <div class="card-body p-4 position-relative z-index-1">
                <div class="d-flex align-items-center mb-2">
                    <h6 class="text-success fw-bold mb-0 text-uppercase" style="font-size: 0.8rem;">Estimasi Komisi Pribadi</h6>
                </div>
                <h2 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPoints, 0, ',', '.') }}</h2>
                <div class="mt-2 text-muted small"><i class="bi bi-info-circle me-1"></i> Didapat saat anggota Aktif</div>
            </div>
        </div>
    </div>

    <!-- Status: Affiliator -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-secondary">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-secondary bg-opacity-10 text-secondary py-2 px-3 rounded-3 me-3">
                        <i class="bi bi-person-lines-fill fs-4"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.8rem;">Status: Prospek</h6>
                </div>
                <h2 class="fw-bold text-dark mb-0 display-6">{{ $prospectsCount }} <span class="fs-6 text-muted fw-normal">Orang</span></h2>
                <div class="mt-1 small text-muted">Belum mendaftar resmi</div>
            </div>
        </div>
    </div>

    <!-- Status: Terdaftar -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-primary">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-3 me-3">
                        <i class="bi bi-file-earmark-person-fill fs-4"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.8rem;">Status: Terdaftar</h6>
                </div>
                <h2 class="fw-bold text-dark mb-0 display-6">{{ $registeredStudentsCount }} <span class="fs-6 text-muted fw-normal">Orang</span></h2>
                <div class="mt-1 small text-muted">Sedang proses verifikasi/bayar</div>
            </div>
        </div>
    </div>

    <!-- Status: Aktif / Bayar -->
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-success">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success py-2 px-3 rounded-3 me-3">
                        <i class="bi bi-person-check-fill fs-4"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.8rem;">Status: Aktif / Bayar</h6>
                </div>
                <h2 class="fw-bold text-dark mb-0 display-6">{{ $activeStudentsCount }} <span class="fs-6 text-muted fw-normal">Orang</span></h2>
                <div class="mt-1 small text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i>Menghasilkan Komisi</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-center mt-3 mb-5">
        <a href="{{ route('affiliator.students.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-list-task me-2"></i> Lihat Daftar Lengkap Mahasiswa & Prospek Saya
        </a>
    </div>
</div>


@push('scripts')
<script>
    function copyReferralLink(btn) {
        var copyText = document.getElementById("referralLinkInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        navigator.clipboard.writeText(copyText.value);
        
        var originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-lg"></i> <span class="d-none d-md-inline ms-1">Tersalin!</span>';
        btn.classList.remove('btn-warning');
        btn.classList.add('btn-success', 'text-white');
        
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.classList.remove('btn-success', 'text-white');
            btn.classList.add('btn-warning');
        }, 3000);
    }
</script>
@endpush
@endsection
