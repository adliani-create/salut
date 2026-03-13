@extends('layouts.affiliator')

@section('title', 'Komisi & Penarikan')

@section('content')
<div class="row g-4 mb-4">
    <!-- Peringatan Bank -->
    @if(empty(Auth::user()->bank_name) || empty(Auth::user()->bank_account))
    <div class="col-12">
        <div class="alert alert-warning border-0 shadow-sm rounded-4 d-flex align-items-center mb-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
            <div>
                <strong>Perhatian!</strong> Anda belum melengkapi data rekening bank pencairan Anda.
                <br>Silakan lengkapi di <a href="{{ route('profile.edit') }}" class="alert-link">Pengaturan Profil</a> sebelum melakukan penarikan dana.
            </div>
        </div>
    </div>
    @endif

    <!-- Total Komisi -->
    <div class="col-md-6 mb-4 mb-md-0">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 overflow-hidden position-relative">
            <div class="position-absolute end-0 top-50 translate-middle-y opacity-10" style="margin-right: -20px;">
                <i class="bi bi-wallet2" style="font-size: 10rem;"></i>
            </div>
            <div class="card-body p-4 p-md-5 position-relative z-index-1">
                <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Saldo Tersedia</span>
                <h1 class="display-4 fw-bold mb-1">Rp {{ number_format(Auth::user()->total_points, 0, ',', '.') }}</h1>
                <p class="mb-0 fs-5 text-white-50">Saldo terkumpul dari komisi rekrutmen dan bonus supervisi tim.</p>
            </div>
        </div>
    </div>

    <!-- Form Tarik Dana -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-cash-stack text-success me-2"></i>Tarik Saldo (Rupiah)</h6>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger rounded-3 py-2 mb-3"><i class="bi bi-x-circle me-2"></i>{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success rounded-3 py-2 mb-3"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
                @endif

                <form action="{{ route('affiliator.finance.withdraw') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Jumlah Saldo yang Ditarik</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-cash text-success"></i></span>
                            <input type="number" name="amount" class="form-control bg-light border-start-0 ps-0" placeholder="Minimal Rp 50.000" min="50000" max="{{ Auth::user()->total_points }}" required {{ (empty(Auth::user()->bank_name) || Auth::user()->total_points < 50000) ? 'disabled' : '' }}>
                        </div>
                        <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Min. penarikan Rp 50.000. Pastikan rekening di profil Anda valid.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3" {{ (empty(Auth::user()->bank_name) || Auth::user()->total_points < 50000) ? 'disabled' : '' }}>
                        <i class="bi bi-arrow-down-circle me-2"></i>Ajukan Penarikan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-3">
        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-secondary me-2"></i>Riwayat Transaksi</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">Tanggal & Waktu</th>
                        <th>Keterangan</th>
                        <th class="text-center">Tipe</th>
                        <th class="pe-4 text-end">Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ledgers as $ledger)
                    <tr>
                        <td class="ps-4 py-3">
                            <span class="d-block text-dark fw-bold">{{ $ledger->created_at->translatedFormat('d F Y') }}</span>
                            <small class="text-muted">{{ $ledger->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <span class="d-block">{{ $ledger->description }}</span>
                            @if($ledger->sourceUser)
                                <small class="text-muted"><i class="bi bi-person me-1"></i>{{ $ledger->sourceUser->name }} ({{ $ledger->sourceUser->role->name }})</small>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($ledger->type == 'credit')
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2"><i class="bi bi-arrow-down-left me-1"></i> Pemasukan</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2"><i class="bi bi-arrow-up-right me-1"></i> Penarikan</span>
                            @endif
                        </td>
                        <td class="pe-4 py-3 text-end fw-bold {{ $ledger->type == 'credit' ? 'text-success' : 'text-danger' }}">
                            {{ $ledger->type == 'credit' ? '+' : '-' }} Rp {{ number_format($ledger->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-1 opacity-25 d-block mb-3"></i>
                            Belum ada riwayat komisi atau penarikan.<br>
                            Ajak lebih banyak orang untuk mendapatkan komisi!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($ledgers->hasPages())
        <div class="card-footer bg-white border-top py-3">
            {{ $ledgers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
