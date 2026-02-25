@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.mitras.index') }}" class="btn btn-light rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="h3 mb-0 text-gray-800">Detail & Jaringan Mitra</h2>
            <p class="text-muted mb-0">Pantau performa dan struktur afiliasi dari Mitra ini.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="bi bi-diagram-3 position-absolute end-0 top-0 opacity-10" style="font-size: 8rem; margin-top: -20px; margin-right: -20px;"></i>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="mb-4 opacity-75">{{ optional($user->mitraProfile)->company_name ?? 'Mitra Perorangan' }}</p>
                    
                    <div class="d-flex align-items-center justify-content-between bg-white bg-opacity-25 rounded-3 p-3 mb-3">
                        <div>
                            <small class="d-block text-uppercase fw-bold opacity-75">Kode Referral</small>
                            <span class="fs-5 font-monospace fw-bold">{{ $user->referral_code }}</span>
                        </div>
                        <i class="bi bi-qr-code-scan fs-3"></i>
                    </div>

                    <div class="d-flex justify-content-between text-center mt-4 border-top border-white border-opacity-25 pt-3">
                        <div>
                            <h4 class="fw-bold mb-0">{{ $user->referrals->count() }}</h4>
                            <small class="opacity-75">Afiliator</small>
                        </div>
                        <div>
                            @php
                                $totalMahasiswa = 0;
                                foreach($user->referrals as $affiliator) {
                                    $totalMahasiswa += User::where('referred_by', $affiliator->id)->whereHas('role', function($q){ $q->where('name', 'mahasiswa'); })->count();
                                }
                            @endphp
                            <h4 class="fw-bold mb-0">{{ $totalMahasiswa }}</h4>
                            <small class="opacity-75">Mahasiswa</small>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">{{ number_format($user->total_points, 0, ',', '.') }}</h4>
                            <small class="opacity-75">Total Poin</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Profil & Rekening</h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Nama Lengkap / PIC</small>
                            <strong>{{ $user->name }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Kontak Utama</small>
                            <strong><i class="bi bi-envelope text-muted"></i> {{ $user->email }}<br>
                            <i class="bi bi-whatsapp text-success"></i> {{ $user->whatsapp ?? '-' }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Alamat</small>
                            <strong>{{ optional($user->mitraProfile)->address ?? '-' }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Informasi Pencairan (Bank)</small>
                            @if(optional($user->mitraProfile)->bank_name)
                                <div class="bg-light p-2 rounded-3 mt-1 border">
                                    <strong>{{ $user->mitraProfile->bank_name }}</strong><br>
                                    <span class="font-monospace text-primary">{{ $user->mitraProfile->bank_account_number }}</span><br>
                                    <small class="text-muted">A.n. {{ $user->mitraProfile->bank_account_name }}</small>
                                </div>
                            @else
                                <span class="text-danger border border-danger px-2 py-1 rounded small">Belum diatur</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tree View -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center border-bottom pb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-diagram-2 me-2 text-primary"></i>Struktur Afiliator</h5>
            <span class="badge bg-primary rounded-pill">{{ $user->referrals->count() }} Orang</span>
        </div>
        <div class="card-body p-0">
            <div class="accordion accordion-flush" id="affiliateTree">
                @forelse($user->referrals as $index => $affiliator)
                @php
                    $mahasiswaList = User::where('referred_by', $affiliator->id)
                                         ->whereHas('role', function($q){ $q->where('name', 'mahasiswa'); })
                                         ->get();
                @endphp
                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header" id="heading{{ $index }}">
                        <button class="accordion-button collapsed py-3 {{ $mahasiswaList->isEmpty() ? 'shadow-none bg-light' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                            <div class="d-flex align-items-center w-100 pe-3">
                                <div class="avatar bg-info text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-bold">{{ $affiliator->name }}</h6>
                                    <small class="text-muted">Kode: <span class="font-monospace">{{ $affiliator->referral_code ?? '-' }}</span></small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success rounded-pill">{{ $mahasiswaList->count() }} Mahasiswa</span>
                                    <span class="badge bg-primary rounded-pill ms-1">{{ number_format($affiliator->total_points, 0, ',', '.') }} Poin</span>
                                </div>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#affiliateTree">
                        <div class="accordion-body p-0 bg-light">
                            @if($mahasiswaList->isNotEmpty())
                                <ul class="list-group list-group-flush border-top border-bottom">
                                    @foreach($mahasiswaList as $mhs)
                                    <li class="list-group-item bg-transparent border-0 d-flex justify-content-between align-items-center py-2 px-5 position-relative">
                                        <!-- tree branch UI line -->
                                        <div class="position-absolute border-start border-bottom border-secondary" style="width: 20px; height: 30px; top: -10px; left: 35px; opacity: 0.3;"></div>
                                        
                                        <div>
                                            <span class="fw-bold ms-2">{{ $mhs->name }}</span>
                                            <small class="text-muted ms-2">({{ $mhs->nim ?? 'NIM belum ada' }})</small>
                                        </div>
                                        <div>
                                            <span class="badge {{ $mhs->status === 'active' ? 'bg-success' : 'bg-warning' }} rounded-pill">{{ ucfirst($mhs->status) }}</span>
                                            <small class="text-muted ms-3">{{ $mhs->created_at->format('d M Y') }}</small>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="py-3 px-5 text-muted small"><i class="bi bi-info-circle me-1"></i> Afiliator ini belum mendaftarkan mahasiswa.</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforelse

                @if($user->referrals->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-diagram-2 empty-icon fs-1 d-block mb-3 opacity-50"></i>
                    Mitra ini belum memiliki tim affiliator.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: inherit;
    box-shadow: none;
}
.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,.125);
}
</style>
@endsection
