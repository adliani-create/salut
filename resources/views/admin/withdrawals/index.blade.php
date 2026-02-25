@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800">Permintaan Pencairan Poin</h2>
            <p class="text-muted mb-0">Kelola dan proses permintaan withdrawal dari Mitra & Afiliator.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body py-3 border-bottom d-flex align-items-center">
            <ul class="nav nav-pills text-sm">
                <li class="nav-item">
                    <a class="nav-link rounded-pill px-3 py-2 {{ $status === 'pending' ? 'active shadow-sm' : 'text-dark' }}" href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}">Menunggu Proses</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link rounded-pill px-3 py-2 {{ $status === 'approved' ? 'active shadow-sm' : 'text-dark' }}" href="{{ route('admin.withdrawals.index', ['status' => 'approved']) }}">Telah Ditransfer</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link rounded-pill px-3 py-2 {{ $status === 'rejected' ? 'active shadow-sm' : 'text-dark' }}" href="{{ route('admin.withdrawals.index', ['status' => 'rejected']) }}">Ditolak</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link rounded-pill px-3 py-2 {{ $status === 'all' ? 'active shadow-sm bg-secondary text-white' : 'text-dark' }}" href="{{ route('admin.withdrawals.index', ['status' => 'all']) }}">Semua Status</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Tanggal Pengajuan</th>
                            <th class="py-3">Mitra / Afiliator</th>
                            <th class="py-3">Jumlah Penarikan</th>
                            <th class="py-3">Rekening Tujuan</th>
                            <th class="py-3">Status</th>
                            @if($status === 'pending')
                            <th class="pe-4 py-3 text-end">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $wd)
                        <tr>
                            <td class="ps-4 py-3">
                                <span class="fw-bold">{{ $wd->created_at->format('d M Y') }}</span><br>
                                <small class="text-muted">{{ $wd->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td class="py-3">
                                <strong>{{ $wd->user->name }}</strong><br>
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ ucfirst($wd->user->role->name) }}</span>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-success fs-5">{{ number_format($wd->amount, 0, ',', '.') }} Poin</span>
                            </td>
                            <td class="py-3">
                                <div class="bg-light p-2 rounded small d-inline-block border">
                                    <span class="fw-bold text-dark">{{ $wd->bank_name }}</span> - <span class="font-monospace">{{ $wd->account_number }}</span><br>
                                    <span class="text-muted">A.n. {{ $wd->account_name }}</span>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($wd->status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-clock me-1"></i> Pending</span>
                                @elseif($wd->status === 'approved')
                                    <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span><br>
                                    <small class="text-muted d-block mt-1">Oleh: {{ optional($wd->processor)->name }}</small>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @endif
                            </td>
                            
                            @if($status === 'pending')
                            <td class="pe-4 py-3 text-end">
                                <button type="button" class="btn btn-sm btn-success fw-bold rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#processModal{{ $wd->id }}">
                                    Proses Pencairan
                                </button>

                                <!-- Process Modal -->
                                <div class="modal fade" id="processModal{{ $wd->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered text-start">
                                        <div class="modal-content border-0 rounded-4 shadow">
                                            <div class="modal-header border-0 bg-light">
                                                <h5 class="modal-title fw-bold">Proses Pencairan: {{ $wd->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 mb-4 text-center">
                                                    <span class="d-block mb-1">Jumlah Tarik</span>
                                                    <h3 class="fw-bold mb-0 text-success">{{ number_format($wd->amount, 0, ',', '.') }} Poin</h3>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <h6 class="fw-bold fs-6 mb-2">Transfer ke Rekening:</h6>
                                                    <table class="table table-sm table-borderless mb-0 bg-light rounded-3 p-2 d-table w-100">
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-muted w-25">Bank</td>
                                                                <td class="fw-bold">{{ $wd->bank_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">No Rek</td>
                                                                <td class="fw-bold font-monospace">{{ $wd->account_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted">Atas Nama</td>
                                                                <td class="fw-bold">{{ $wd->account_name }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <hr>
                                                
                                                <p class="text-muted small">Pilih aksi di bawah ini. Pastikan Anda telah mentransfer dana ke rekening yang tertera sebelum menyetujui.</p>

                                                <div class="d-flex gap-2 justify-content-end mt-4">
                                                    <!-- Reject Form -->
                                                    <form action="{{ route('admin.withdrawals.reject', $wd) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Yakin ingin menolak dan mengembalikan poin ke pengguna?');">
                                                        @csrf
                                                        <input type="hidden" name="notes" value="Ditolak oleh Admin. Poin dikembalikan.">
                                                        <button type="submit" class="btn btn-outline-danger border-2 rounded-pill w-100 fw-bold">
                                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Approve Form -->
                                                    <form action="{{ route('admin.withdrawals.approve', $wd) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('Saya konfirmasi bahwa dana SUDAH DITRANSFER ke rekening tujuan.');">
                                                        @csrf
                                                        <input type="hidden" name="notes" value="Telah ditransfer.">
                                                        <button type="submit" class="btn btn-success shadow-sm rounded-pill w-100 fw-bold">
                                                            <i class="bi bi-check2-circle me-1"></i> Tandai Selesai (Lunas)
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $status === 'pending' ? '6' : '5' }}" class="text-center py-5 text-muted">
                                <i class="bi bi-wallet2 fs-1 d-block mb-3 opacity-50"></i>
                                Tidak ada data pencairan untuk status ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($withdrawals->hasPages())
            <div class="card-footer bg-white border-top py-3">
                {{ $withdrawals->appends(['status' => $status])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
