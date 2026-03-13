@extends('layouts.mitra')

@section('title', 'Dashboard Overview')

@section('content')

@if(Auth::user()->status === 'pending')
{{-- ============================================================ --}}
{{-- PENDING MITRA VIEW - Shown when account is awaiting approval --}}
{{-- ============================================================ --}}
<div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="bg-warning text-dark text-center p-5">
                <i class="bi bi-hourglass-split display-2 mb-3 d-block opacity-75"></i>
                <h3 class="fw-bold">Pendaftaran Mitra Sedang Ditinjau</h3>
                <p class="mb-0 opacity-75">Terima kasih telah mendaftar sebagai Mitra SALUT!</p>
            </div>
            <div class="card-body p-5">
                <p class="text-muted mb-4">
                    Pengajuan Mitra Anda sedang dalam proses <strong>peninjauan oleh Admin</strong>. Biasanya proses ini memerlukan <strong>1–2 hari kerja</strong>. Kami akan menghubungi Anda melalui WhatsApp atau Email yang terdaftar jika pengajuan disetujui atau memerlukan informasi tambahan.
                </p>
                <div class="bg-light rounded-4 p-4 mb-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-vcard me-2 text-primary"></i>Data Pendaftaran Anda</h6>
                    <div class="row g-2 small">
                        <div class="col-6 text-muted">Nama</div>
                        <div class="col-6 fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="col-6 text-muted">Email</div>
                        <div class="col-6 fw-bold text-dark">{{ Auth::user()->email }}</div>
                        <div class="col-6 text-muted">WhatsApp</div>
                        <div class="col-6 fw-bold text-dark">{{ Auth::user()->whatsapp ?? '-' }}</div>
                        <div class="col-6 text-muted">Status</div>
                        <div class="col-6">
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold">
                                <i class="bi bi-clock-history me-1"></i> Menunggu Persetujuan
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('pending-logout-form').submit();" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="pending-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

@else
{{-- ============================================================ --}}
{{-- ACTIVE MITRA DASHBOARD - Normal view for approved mitras     --}}
{{-- ============================================================ --}}


<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white border-0 shadow-sm rounded-4 overflow-hidden position-relative">
            <!-- Background Decoration -->
            <div class="position-absolute end-0 top-0 h-100 d-none d-lg-block" style="margin-right: -20px; margin-top: -20px; pointer-events: none;">
                <i class="bi bi-bullseye text-white opacity-10" style="font-size: 15rem;"></i>
            </div>
            
            <div class="card-body p-3 p-md-4 p-lg-5 position-relative" style="z-index: 1;">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-3 mb-lg-0">
                        <span class="badge bg-white text-primary mb-2 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.7rem;">Pusat Pemasaran & Rekrutmen</span>
                        <h4 class="fw-bold mb-2 fs-5">Kembangkan Jaringan Anda</h4>
                        <p class="mb-0 text-white-50 small">Bagikan link di bawah ini sesuai dengan target rekrutmen Anda. Kode: <strong class="text-white">{{ Auth::user()->referral_code }}</strong></p>
                    </div>
                    <div class="col-lg-7">
                        <ul class="nav nav-pills mb-2 border-bottom border-white border-opacity-25 pb-2 flex-nowrap" id="pills-tab" role="tablist">
                          <li class="nav-item" role="presentation">
                            <button class="nav-link active text-white fw-bold rounded-pill py-1 px-2 px-md-3 small" id="pills-affiliator-tab" data-bs-toggle="pill" data-bs-target="#pills-affiliator" type="button" role="tab" style="background-color: rgba(255,255,255,0.1); font-size: 0.75rem;">
                                <i class="bi bi-person-badge me-1"></i>Rekrut Affiliator
                            </button>
                          </li>
                          <li class="nav-item ms-1" role="presentation">
                            <button class="nav-link text-white fw-bold rounded-pill py-1 px-2 px-md-3 small" id="pills-maba-tab" data-bs-toggle="pill" data-bs-target="#pills-maba" type="button" role="tab" style="background-color: rgba(255,255,255,0.1); font-size: 0.75rem;">
                                <i class="bi bi-mortarboard me-1"></i>Rekrut Mahasiswa
                            </button>
                          </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                          <!-- Tab Affiliator -->
                          <div class="tab-pane fade show active" id="pills-affiliator" role="tabpanel" tabindex="0">
                              <div class="bg-dark bg-opacity-25 rounded-3 p-2 p-md-3 border border-white border-opacity-25 mt-1">
                                  <label class="text-white-50 mb-1 fw-bold d-block" style="font-size: 0.65rem;"><i class="bi bi-link-45deg me-1"></i>Link Pendaftaran Affiliator Baru</label>
                                  <div class="input-group">
                                      <input type="text" id="affiliateLinkInput" class="form-control bg-white text-dark fw-bold border-0 py-2 small" value="{{ $affiliateReferralLink }}" readonly style="min-width: 0;">
                                      <button class="btn btn-warning fw-bold px-2 px-md-3 flex-shrink-0" type="button" onclick="copyDynamicLink('affiliateLinkInput', this)">
                                          <i class="bi bi-copy"></i><span class="d-none d-md-inline ms-1">Salin</span>
                                      </button>
                                  </div>
                              </div>
                          </div>
                          
                          <!-- Tab Mahasiswa -->
                          <div class="tab-pane fade" id="pills-maba" role="tabpanel" tabindex="0">
                              <div class="bg-dark bg-opacity-25 rounded-3 p-2 p-md-3 border border-white border-opacity-25 mt-1">
                                  <label class="text-white-50 mb-1 fw-bold d-block" style="font-size: 0.65rem;"><i class="bi bi-link-45deg me-1"></i>Link Pendaftaran Mahasiswa Baru</label>
                                  <div class="input-group">
                                      <input type="text" id="mabaLinkInput" class="form-control bg-white text-dark fw-bold border-0 py-2 small" value="{{ $referralLink }}" readonly style="min-width: 0;">
                                      <button class="btn btn-warning fw-bold px-2 px-md-3 flex-shrink-0" type="button" onclick="copyDynamicLink('mabaLinkInput', this)">
                                          <i class="bi bi-copy"></i><span class="d-none d-md-inline ms-1">Salin</span>
                                      </button>
                                  </div>
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
    <div class="col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success py-2 px-3 rounded-3 me-3">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.8rem;">Estimasi Komisi<br>Pribadi</h6>
                </div>
                <h2 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPoints, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary bg-opacity-10 py-2">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-primary fw-bold mb-1 text-uppercase" style="font-size: 0.8rem;">Total Tim Affiliator</h6>
                    <h2 class="fw-bold text-dark mb-0 display-5">{{ $totalAffiliators }} <span class="fs-6 text-muted fw-normal">Orang</span></h2>
                </div>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                    <i class="bi bi-diagram-3-fill fs-2"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 text-info py-2 px-3 rounded-3 me-3">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <h6 class="text-muted fw-bold mb-0 text-uppercase" style="font-size: 0.8rem;">Total Maba<br>(Jaringan)</h6>
                </div>
                <h2 class="fw-bold text-dark mb-0 d-flex align-items-baseline">
                    {{ $totalStudentsFromTeam }} <span class="fs-6 text-muted fw-normal ms-2">Mahasiswa</span>
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: Affiliator Terbaru & Statistik Tim -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-stars text-warning me-2"></i>Affiliator Terbaru di Tim Anda</h6>
                <a href="{{ route('mitra.network.affiliators') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nama Affiliator</th>
                                <th>Email & Kontak</th>
                                <th>Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAffiliators as $affiliator)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                            {{ substr($affiliator->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark">{{ $affiliator->name }}</strong>
                                            <span class="badge bg-light text-dark font-monospace border mt-1">{{ $affiliator->referral_code }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="d-block small"><i class="bi bi-envelope text-muted me-2"></i>{{ $affiliator->email }}</span>
                                    <span class="d-block small text-success fw-bold"><i class="bi bi-whatsapp me-2"></i>{{ $affiliator->whatsapp ?? '-' }}</span>
                                </td>
                                <td>
                                    {{ $affiliator->created_at->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-diagram-3 fs-1 opacity-25 d-block mb-3"></i>
                                    Belum ada Affiliator yang bergabung di jaringan Anda.<br>
                                    Ayo bagikan link rekrutmen di atas!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart-fill text-info me-2"></i>Top Performa Tim</h6>
                <span class="badge bg-light text-dark border">Berdasarkan Jumlah Maba</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush mb-0">
                    @forelse($teamStats as $index => $stat)
                    <li class="list-group-item px-4 py-3 border-0 border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-center me-3" style="width: 25px;">
                                @if($index === 0)
                                    <i class="bi bi-trophy-fill text-warning fs-5"></i>
                                @elseif($index === 1)
                                    <i class="bi bi-award-fill text-secondary fs-5"></i>
                                @elseif($index === 2)
                                    <i class="bi bi-award-fill text-danger fs-5 " style="color: #cd7f32 !important;"></i>
                                @else
                                    <span class="text-muted fw-bold">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <div class="avatar bg-light text-dark border rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                {{ substr($stat->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">{{ $stat->name }}</h6>
                                <small class="text-muted font-monospace">{{ $stat->referral_code }}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $stat->students_count > 0 ? 'bg-info text-white' : 'bg-secondary bg-opacity-10 text-secondary' }} rounded-pill px-3 py-2 fs-6">
                                {{ $stat->students_count }} <i class="bi bi-people-fill ms-1"></i>
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-5 border-0 text-muted">
                        <i class="bi bi-graph-down text-muted fs-1 opacity-25 d-block mb-3"></i>
                        Belum ada statistik performa.<br>
                        Tunggu tim Anda merekrut mahasiswa.
                    </li>
                    @endforelse
                </ul>
            </div>
            @if(count($teamStats) > 0)
            <div class="card-footer bg-white border-top text-center py-3">
                <a href="{{ route('mitra.network.affiliators') }}" class="text-decoration-none small fw-bold">Lihat Semua Kinerja Tim <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyDynamicLink(inputId, btn) {
        var copyText = document.getElementById(inputId);
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
        
        // Visual feedback
        var originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check-lg"></i><span class="d-none d-md-inline ms-1">Tersalin!</span>';
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

@endif {{-- End @if(status === 'pending') --}}

@endsection

