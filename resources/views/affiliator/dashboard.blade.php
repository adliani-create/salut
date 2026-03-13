@extends('layouts.affiliator')

@section('title', 'Dashboard Affiliator')

@section('content')

<!-- Recent Transfer Notifications -->
@if(isset($recentTransfers) && $recentTransfers->count() > 0)
    <div class="row mb-3 mb-md-4">
        <div class="col-12">
            @foreach($recentTransfers as $transfer)
            <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-2 alert-dismissible fade show" role="alert">
                <div class="bg-success text-white rounded-circle p-2 me-3 shadow-sm d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                    <i class="bi bi-cash-coin fs-5"></i>
                </div>
                <div class="flex-grow-1 min-w-0">
                    <h6 class="alert-heading fw-bold mb-1 fs-6">Pencairan Transfer Berhasil!</h6>
                    <p class="mb-0 small text-truncate-2">
                        Dana sebesar <strong>Rp {{ number_format($transfer->amount, 0, ',', '.') }}</strong> 
                        telah berhasil ditransfer ke rekening <strong>{{ $transfer->bank_name }}</strong> Anda pada {{ $transfer->updated_at->format('d M Y, H:i') }}.
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Referral Copy Section -->
<div class="row mb-3 mb-md-4">
    <div class="col-12">
        <div class="card bg-primary text-white border-0 shadow-sm rounded-4 overflow-hidden position-relative">
            <!-- Background Decoration -->
            <div class="position-absolute end-0 top-0 h-100 text-white opacity-10 d-none d-lg-block" style="margin-right: -20px; margin-top: -20px; pointer-events: none; z-index: 0;">
                <i class="bi bi-briefcase-fill" style="font-size: 15rem;"></i>
            </div>
            
            <div class="card-body p-3 p-md-4 p-lg-5 position-relative" style="z-index: 1;">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <span class="badge bg-white text-primary mb-2 mb-md-3 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem;">Penambahan Mahasiswa</span>
                        <h4 class="fw-bold mb-2 mb-md-3 fs-5 fs-md-4">Mulai Merekrut Mahasiswa Baru</h4>
                        <p class="mb-0 text-white-50 small">Bagikan link ini ke calon mahasiswa. Setiap mahasiswa yang mendaftar dan <strong class="text-white">disetujui (bayar)</strong> otomatis memberikan Anda komisi.</p>
                        
                        <div class="mt-3">
                            <a href="{{ route('affiliator.students.create') }}" class="btn btn-light btn-sm btn-md-lg text-primary fw-bold rounded-pill px-3 px-md-4 shadow-sm">
                                <i class="bi bi-person-plus-fill me-1 me-md-2"></i> Input Mahasiswa Manual
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="bg-dark bg-opacity-25 rounded-4 p-3 border border-white border-opacity-25 shadow">
                            <label class="small text-white-50 text-uppercase mb-2 fw-bold d-block" style="font-size: 0.7rem;"><i class="bi bi-link-45deg me-1 align-middle"></i> Link Referral Anda</label>
                            <div class="input-group border border-2 border-white border-opacity-50 rounded-3 overflow-hidden">
                                <input type="text" id="referralLinkInput" class="form-control bg-white text-dark fw-bold border-0 py-2 small" value="{{ $referralLink }}" readonly style="min-width: 0;">
                                <button class="btn btn-warning fw-bold px-3 text-dark flex-shrink-0" type="button" onclick="copyReferralLink(this)">
                                    <i class="bi bi-copy"></i><span class="d-none d-sm-inline ms-1"> Salin</span>
                                </button>
                            </div>
                            <div class="text-center mt-2">
                                <div class="badge bg-white bg-opacity-25 text-white px-3 py-1 rounded-pill font-monospace small" style="letter-spacing: 1px;">
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
<div class="row g-3 g-md-4 mb-3 mb-md-4">
    <!-- Poin Komisi -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 position-relative overflow-hidden bg-success bg-opacity-10">
            <div class="position-absolute end-0 bottom-0 opacity-25 p-2 d-none d-sm-block">
                <i class="bi bi-wallet2 display-4 text-success"></i>
            </div>
            <div class="card-body p-3 p-md-4 position-relative z-index-1">
                <h6 class="text-success fw-bold mb-1 text-uppercase" style="font-size: 0.65rem;">Estimasi Komisi</h6>
                <h3 class="fw-bold text-dark mb-0 fs-5 fs-md-4">Rp {{ number_format($totalPoints, 0, ',', '.') }}</h3>
                <div class="mt-1 text-muted d-none d-md-block" style="font-size: 0.7rem;"><i class="bi bi-info-circle me-1"></i> Didapat saat anggota Aktif</div>
            </div>
        </div>
    </div>

    <!-- Status: Prospek -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-secondary">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-secondary bg-opacity-10 text-secondary p-2 rounded-3 me-2 d-none d-sm-flex align-items-center justify-content-center">
                        <i class="bi bi-person-lines-fill fs-5"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.65rem;">Prospek</h6>
                </div>
                <h3 class="fw-bold text-dark mb-0 fs-4">{{ $prospectsCount }} <span class="fs-6 text-muted fw-normal">Orang</span></h3>
                <div class="mt-1 text-muted d-none d-md-block" style="font-size: 0.7rem;">Belum mendaftar resmi</div>
            </div>
        </div>
    </div>

    <!-- Status: Terdaftar -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-primary">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 me-2 d-none d-sm-flex align-items-center justify-content-center">
                        <i class="bi bi-file-earmark-person-fill fs-5"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.65rem;">Terdaftar</h6>
                </div>
                <h3 class="fw-bold text-dark mb-0 fs-4">{{ $registeredStudentsCount }} <span class="fs-6 text-muted fw-normal">Orang</span></h3>
                <div class="mt-1 text-muted d-none d-md-block" style="font-size: 0.7rem;">Sedang proses verifikasi</div>
            </div>
        </div>
    </div>

    <!-- Status: Aktif / Bayar -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-4 border-success">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-success bg-opacity-10 text-success p-2 rounded-3 me-2 d-none d-sm-flex align-items-center justify-content-center">
                        <i class="bi bi-person-check-fill fs-5"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.65rem;">Aktif / Bayar</h6>
                </div>
                <h3 class="fw-bold text-dark mb-0 fs-4">{{ $activeStudentsCount }} <span class="fs-6 text-muted fw-normal">Orang</span></h3>
                <div class="mt-1 text-success fw-bold d-none d-md-block" style="font-size: 0.7rem;"><i class="bi bi-check-circle-fill me-1"></i>Menghasilkan Komisi</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 text-center mt-2 mt-md-3 mb-4 mb-md-5">
        <a href="{{ route('affiliator.students.index') }}" class="btn btn-outline-primary rounded-pill px-3 px-md-4 btn-sm btn-md-default">
            <i class="bi bi-list-task me-1 me-md-2"></i> Lihat Daftar Mahasiswa & Prospek
        </a>
    </div>
</div>


@push('scripts')
<script>
    function copyReferralLink(btn) {
        var copyText = document.getElementById("referralLinkInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        
        // Fallback for HTTP (non-HTTPS) environments
        var copied = false;
        try {
            copied = document.execCommand('copy');
        } catch(e) {
            copied = false;
        }
        
        if (!copied && navigator.clipboard) {
            navigator.clipboard.writeText(copyText.value).catch(function(){});
        }
        
        var originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-lg"></i><span class="d-none d-sm-inline ms-1"> Tersalin!</span>';
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
