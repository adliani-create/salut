@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.affiliators.index') }}" class="btn btn-light rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="h3 mb-0 text-gray-800">Detail Rekrutmen: {{ $affiliator->name }}</h2>
            <p class="text-muted mb-0">Lihat performa rekrutmen mahasiswa oleh affiliator ini.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Affiliator Profil -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white">
                <div class="card-body p-4 position-relative overflow-hidden">
                    <i class="bi bi-person-badge position-absolute end-0 top-0 opacity-10" style="font-size: 8rem; margin-top: -20px; margin-right: -20px;"></i>
                    
                    <div class="d-flex align-items-center mb-4">
                         <div class="avatar bg-white bg-opacity-25 text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 60px; height: 60px;">
                            {{ substr($affiliator->name, 0, 1) }}
                        </div>
                        <div>
                             <h4 class="fw-bold mb-1">{{ $affiliator->name }}</h4>
                             <p class="mb-0 opacity-75 fs-6"><i class="bi bi-envelope me-1"></i> {{ $affiliator->email }}</p>
                             <p class="mb-0 text-warning fw-bold fs-6"><i class="bi bi-whatsapp me-1"></i> {{ $affiliator->whatsapp ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between bg-white bg-opacity-25 rounded-3 p-3 mb-3">
                        <div>
                            <small class="d-block text-uppercase fw-bold opacity-75">Kode Referral</small>
                            <span class="fs-4 font-monospace fw-bold">{{ $affiliator->referral_code }}</span>
                        </div>
                        <i class="bi bi-qr-code-scan fs-2"></i>
                    </div>

                    <div class="bg-dark bg-opacity-25 rounded-3 p-3">
                        <small class="d-block text-uppercase fw-bold opacity-75 mb-1">Upline / Mitra Penanggung Jawab</small>
                        @if($affiliator->referrer)
                            <div class="d-flex align-items-center">
                                <i class="bi bi-buildings fs-3 me-2 text-warning"></i>
                                <div>
                                    <strong class="d-block">{{ $affiliator->referrer->name }}</strong>
                                    <small>{{ $affiliator->referrer->referral_code }}</small>
                                </div>
                            </div>
                        @else
                            <span class="fst-italic opacity-75">Tidak ada Mitra Upline (Pendaftaran Independen)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekapan Statistik -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Statistik Performa</h6>
                </div>
                <div class="card-body">
                    <div class="row g-4 text-center mt-2">
                        <div class="col-6">
                            <div class="p-4 bg-light rounded-4 border">
                                <i class="bi bi-people text-info fs-1 d-block mb-2"></i>
                                <h2 class="fw-bold mb-0 text-dark">{{ $students->total() }}</h2>
                                <span class="text-muted text-uppercase small fw-bold">Total Rekrut</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-4 bg-light rounded-4 border">
                                <i class="bi bi-cash-coin text-success fs-1 d-block mb-2"></i>
                                <h2 class="fw-bold mb-0 text-dark">{{ number_format($affiliator->total_points, 0, ',', '.') }}</h2>
                                <span class="text-muted text-uppercase small fw-bold">Total Poin Valid</span>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4 text-start">
                             <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Status Pencairan</h6>
                             @php
                                $totalWithdrawn = \App\Models\Withdrawal::where('user_id', $affiliator->id)->where('status', 'approved')->sum('amount');
                                $totalPendingWd = \App\Models\Withdrawal::where('user_id', $affiliator->id)->where('status', 'pending')->sum('amount');
                             @endphp
                             
                             <div class="d-flex justify-content-between mb-2">
                                 <span class="text-muted">Total Poin Dicairkan:</span>
                                 <strong class="text-success">{{ number_format($totalWithdrawn, 0, ',', '.') }} Poin</strong>
                             </div>
                             <div class="d-flex justify-content-between">
                                 <span class="text-muted">Pencairan Tertunda (Pending):</span>
                                 <strong class="text-warning text-dark">{{ number_format($totalPendingWd, 0, ',', '.') }} Poin</strong>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Mahasiswa (Drill Down) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center border-bottom pb-3">
            <h5 class="fw-bold mb-0"><i class="bi bi-mortarboard-fill me-2 text-primary"></i>Riwayat Mahasiswa Terundang</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Nama Mahasiswa</th>
                            <th class="py-3">NIM</th>
                            <th class="py-3">Tanggal Pendaftaran</th>
                            <th class="py-3">Program / Fakultas</th>
                            <th class="py-3">Status Akun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $mhs)
                        <tr>
                            <td class="ps-4 py-3">
                                <strong>{{ $mhs->name }}</strong><br>
                                <small class="text-muted">{{ $mhs->email }}</small>
                            </td>
                            <td class="py-3">
                                @if($mhs->nim)
                                    <span class="font-monospace text-primary fw-bold">{{ $mhs->nim }}</span>
                                @else
                                    <span class="text-muted small fst-italic">Belum memiliki NIM</span>
                                @endif
                            </td>
                            <td class="py-3">
                                {{ $mhs->created_at->format('d M Y') }}<br>
                                <small class="text-muted">{{ $mhs->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td class="py-3">
                                @if(optional($mhs->registration)->fokus_karir)
                                    <span class="badge bg-light text-dark border">{{ $mhs->registration->fokus_karir }}</span>
                                @else
                                    <span class="badge bg-light text-dark border">{{ $mhs->faculty ?? 'Belum Lengkap' }}</span>
                                @endif
                                <br>
                                <small class="text-muted">{{ $mhs->major ?? '-' }}</small>
                            </td>
                            <td class="py-3">
                                @if($mhs->status === 'active')
                                    <span class="badge bg-success rounded-pill px-3"><i class="bi bi-check-circle me-1"></i> Mahasiswa Aktif</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3"><i class="bi bi-clock me-1"></i> {{ ucfirst($mhs->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-50"></i>
                                Affiliator ini belum berhasil merekrut mahasiswa.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($students->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $students->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
